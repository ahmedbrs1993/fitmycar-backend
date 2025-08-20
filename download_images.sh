#!/usr/bin/env bash
set -euo pipefail

# download into backend/public/images/products
TARGET_DIR="backend/public/images/products"
mkdir -p "$TARGET_DIR"
cd "$TARGET_DIR"

# Google Drive file IDs
IDS=(
  "1LsCNyC3h37KvzwDmX-Tc1UO4_8vhRpqQ"
  "15c3x9crJR1qN7jiq4dgnOZP0fbthXkqA"
  "1zCtFXXlt5htg96Q4c33JrzsuZW0FYUAt"
  "1zDQOjZY_RsZY3b4z7mM_qVs_KbVp43VC"
  "17VNY2AuLUw_Ue2BvGyfnGyR0ym89cHCi"
  "10JQSp9uPcLtcoXzGHldvxrRpTUXBuNS7"
  "1lMb-TQgB-DugqWus3KHCgz3JjrgQ0IIs"
  "186DigP3FUDPAy5WmhSmcdXw0FjoMymfU"
  "1zcT904bZqJ8FwTR1KUbQA5kdteHrjIo3"
  "1BfKDEQsq6CY6iXzymzItNc0TfbGC42GY"
  "1IXDDMVxlDcr-FDdpO7LtmmVaKGo8c4DU"
  "1Mv9uL-FUoWEwiy1SYW04pbrnfowfDYtT"
  "1mZPkupeKbBoiReZpDzLv5fJnNy5dX0lp"
  "1qb7ancMijcrMkmRSlXoLQOaR_PcmkEDM"
)

for ID in "${IDS[@]}"; do
  echo "Downloading $ID ..."
  # First hit to capture confirm token (if any) + cookies
  CONFIRM=$(curl -sc /tmp/gcookie "https://drive.google.com/uc?export=download&id=${ID}" \
    | sed -n 's/.*confirm=\([0-9A-Za-z_]*\).*/\1/p')

  URL="https://drive.google.com/uc?export=download&id=${ID}"
  if [ -n "${CONFIRM}" ]; then
    URL="https://drive.google.com/uc?export=download&confirm=${CONFIRM}&id=${ID}"
  fi

  # -L follow redirects, -b use cookies, -J honor server filename, -O write to that name
  curl -Lb /tmp/gcookie -J -L -O "$URL"
done

echo "✅ Images downloaded to $(pwd)"