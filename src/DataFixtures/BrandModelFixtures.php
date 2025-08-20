<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Fuel;
use App\Entity\FuelType;
use App\Entity\Generation;
use App\Entity\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Generator;

final class BrandModelFixtures extends Fixture implements OrderedFixtureInterface
{
    public function getOrder(): int
    {
        return 2;
    }

    public function load(ObjectManager $manager): void
    {
        $brands = [];
        $models = [];
        $fuelCache = [];

        foreach ($this->getCarData() as [$brandName, $modelName, $generationLabel, $fuelTypes]) {
            // Get or create brand
            if (!isset($brands[$brandName])) {
                $brand = new Brand();
                $brand->setName($brandName);
                $manager->persist($brand);
                $brands[$brandName] = $brand;
            } else {
                $brand = $brands[$brandName];
            }

            // Get or create model
            $modelKey = $brandName . '_' . $modelName;
            if (!isset($models[$modelKey])) {
                $model = new Model();
                $model->setName($modelName);
                $model->setBrand($brand);
                $manager->persist($model);
                $models[$modelKey] = $model;
            } else {
                $model = $models[$modelKey];
            }

            // Generation
            $generation = new Generation();
            $generation->setName($generationLabel);
            $generation->setModel($model);
            $manager->persist($generation);

            foreach ($fuelTypes as $fuelLabel) {
                if (!isset($fuelCache[$fuelLabel])) {
                    $fuelEntity = new Fuel();
                    $fuelEntity->setType($fuelLabel);
                    $manager->persist($fuelEntity);
                    $fuelCache[$fuelLabel] = $fuelEntity;
                }

                $vehicleFuel = new FuelType();
                $vehicleFuel->setFuel($fuelCache[$fuelLabel]);
                $vehicleFuel->setGeneration($generation);
                $manager->persist($vehicleFuel);
            }
        }

        $manager->flush();
    }

    /**
     * @param array<int, array{name: string, generations: string[], fuelType: string[]}> $models
     */
    private function generateBrandModels(string $brand, array $models): Generator
    {
        foreach ($models as $model) {
            foreach ($model['generations'] as $generation) {
                yield [$brand, $model['name'], $generation, $model['fuelType']];
            }
        }
    }

    private function getCarData(): Generator
    {
        yield from $this->generateBrandModels('Seat', [
            ['name' => 'Ibiza', 'generations' => ['1984-1993', '1993-2002', '2002-2008', '2008-2017', '2017-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Leon', 'generations' => ['1999-2005', '2005-2012', '2012-2020', '2020-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Toledo', 'generations' => ['1991-1998', '1998-2004', '2004-2009', '2012-2019'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Alhambra', 'generations' => ['1996-2010', '2010-2020'], 'fuelType' => ['Essence', 'Diesel']],
        ]);
        // --- RENAULT ---
        yield from $this->generateBrandModels('Renault', [
            ['name' => 'Clio', 'generations' => ['1990-1998', '1998-2005', '2005-2012', '2012-2019', '2019-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Mégane', 'generations' => ['1995-2002', '2002-2009', '2008-2016', '2016-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Scénic', 'generations' => ['1996-2003', '2003-2009', '2009-2016', '2016-2022'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Twingo', 'generations' => ['1993-2007', '2007-2014', '2014-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Captur', 'generations' => ['2013-2019', '2019-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);

        // --- PEUGEOT ---
        yield from $this->generateBrandModels('Peugeot', [
            ['name' => '206', 'generations' => ['1998-2012'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => '207', 'generations' => ['2006-2012'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => '208', 'generations' => ['2012-2019', '2019-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => '308', 'generations' => ['2007-2013', '2013-2021', '2021-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => '508', 'generations' => ['2010-2018', '2018-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => '3008', 'generations' => ['2009-2016', '2016-2023', '2023-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => '5008', 'generations' => ['2009-2016', '2017-2023', '2023-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);
        yield from $this->generateBrandModels('Citroën', [
            ['name' => 'C3', 'generations' => ['2002-2009', '2009-2016', '2016-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'C4', 'generations' => ['2004-2010', '2010-2018', '2020-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'C5', 'generations' => ['2001-2008', '2008-2017', '2021-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Berlingo', 'generations' => ['1996-2008', '2008-2018', '2018-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);

        // --- DACIA ---
        yield from $this->generateBrandModels('Dacia', [
            ['name' => 'Logan', 'generations' => ['2004-2012', '2012-2020', '2020-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Sandero', 'generations' => ['2008-2012', '2012-2020', '2020-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Duster', 'generations' => ['2010-2018', '2018-2024', '2024-présent'], 'fuelType' => ['Essence', 'Diesel', 'Hybride']],
        ]);

        // --- OPEL ---
        yield from $this->generateBrandModels('Opel', [
            ['name' => 'Corsa', 'generations' => ['1982-1993', '1993-2000', '2000-2006', '2006-2014', '2014-2019', '2019-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Astra', 'generations' => ['1991-1998', '1998-2004', '2004-2009', '2009-2015', '2015-2021', '2021-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Insignia', 'generations' => ['2008-2017', '2017-2022'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Zafira', 'generations' => ['1999-2005', '2005-2011', '2011-2019'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Mokka', 'generations' => ['2012-2019', '2020-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);

        // --- ALFA ROMEO ---
        yield from $this->generateBrandModels('Alfa Romeo', [
            ['name' => 'Giulietta', 'generations' => ['2010-2020'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Giulia', 'generations' => ['2016-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'MiTo', 'generations' => ['2008-2018'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => '159', 'generations' => ['2005-2011'], 'fuelType' => ['Essence', 'Diesel']],
        ]);
        // --- ŠKODA ---
        yield from $this->generateBrandModels('Škoda', [
            ['name' => 'Fabia', 'generations' => ['1999-2007', '2007-2014', '2014-2021', '2021-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Octavia', 'generations' => ['1996-2004', '2004-2013', '2013-2020', '2020-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Superb', 'generations' => ['2001-2008', '2008-2015', '2015-2024', '2024-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Yeti', 'generations' => ['2009-2017'], 'fuelType' => ['Essence', 'Diesel']],
        ]);

        // --- CHEVROLET ---
        yield from $this->generateBrandModels('Chevrolet', [
            ['name' => 'Aveo', 'generations' => ['2002-2011', '2011-2020'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Cruze', 'generations' => ['2008-2016', '2016-2019'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Spark', 'generations' => ['1998-2005', '2005-2010', '2010-2015', '2015-2022'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Orlando', 'generations' => ['2010-2018'], 'fuelType' => ['Essence', 'Diesel']],
        ]);

        // --- PORSCHE ---
        yield from $this->generateBrandModels('Porsche', [
            ['name' => '911 Carrera', 'generations' => ['1964-1989', '1989-1994', '1994-1998', '1999-2004', '2004-2011', '2011-2019', '2019-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Cayenne', 'generations' => ['2002-2010', '2010-2017', '2017-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Panamera', 'generations' => ['2009-2016', '2016-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Macan', 'generations' => ['2014-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);

        // --- HONDA ---
        yield from $this->generateBrandModels('Honda', [
            ['name' => 'Civic', 'generations' => ['1972-1979', '1979-1983', '1983-1987', '1987-1991', '1991-1995', '1995-2000', '2000-2005', '2005-2011', '2011-2016', '2016-2021', '2021-présent'], 'fuelType' => ['Essence']],
            ['name' => 'Accord', 'generations' => ['1976-1981', '1981-1985', '1985-1989', '1989-1993', '1993-1997', '1997-2002', '2002-2008', '2008-2013', '2013-2017', '2017-2023', '2023-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Jazz', 'generations' => ['2001-2008', '2008-2015', '2015-2020', '2020-présent'], 'fuelType' => ['Essence']],
            ['name' => 'CR-V', 'generations' => ['1995-2001', '2001-2006', '2006-2012', '2012-2017', '2017-2023', '2023-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);
        // --- SUBARU ---
        yield from $this->generateBrandModels('Subaru', [
            ['name' => 'Impreza', 'generations' => ['1992-2000', '2000-2007', '2007-2011', '2011-2016', '2016-2023', '2023-présent'], 'fuelType' => ['Essence']],
            ['name' => 'Forester', 'generations' => ['1997-2002', '2002-2008', '2008-2013', '2013-2018', '2018-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Outback', 'generations' => ['1994-1999', '1999-2004', '2004-2009', '2009-2014', '2014-2020', '2020-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);

        // --- MAZDA ---
        yield from $this->generateBrandModels('Mazda', [
            ['name' => '2', 'generations' => ['2002-2007', '2007-2014', '2014-2023', '2023-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => '3', 'generations' => ['2003-2009', '2009-2013', '2013-2019', '2019-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => '6', 'generations' => ['2002-2008', '2008-2012', '2012-2023'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'CX-3', 'generations' => ['2015-2021', '2021-présent (certains marchés)'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'CX-5', 'generations' => ['2012-2017', '2017-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'MX-5', 'generations' => ['1989-1998', '1998-2005', '2005-2015', '2015-présent'], 'fuelType' => ['Essence']],
        ]);

        // --- MITSUBISHI ---
        yield from $this->generateBrandModels('Mitsubishi', [
            ['name' => 'Lancer', 'generations' => ['1973-1979', '1979-1983', '1983-1988', '1988-1991', '1991-1995', '1995-2000', '2000-2007', '2007-2017'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Outlander', 'generations' => ['2001-2006', '2006-2012', '2012-2021', '2021-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'ASX', 'generations' => ['2010-2023', '2023-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);

        // --- TOYOTA ---
        yield from $this->generateBrandModels('Toyota', [
            ['name' => 'Yaris', 'generations' => ['1999-2005', '2005-2011', '2011-2020', '2020-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Corolla', 'generations' => ['1966-1970', '1970-1974', '1974-1979', '1979-1983', '1983-1987', '1987-1991', '1991-1995', '1995-2000', '2000-2006', '2006-2013', '2013-2018', '2018-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Avensis', 'generations' => ['1997-2003', '2003-2009', '2009-2018'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'RAV4', 'generations' => ['1994-2000', '2000-2005', '2005-2013', '2013-2018', '2018-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Prius', 'generations' => ['1997-2003', '2003-2009', '2009-2015', '2015-2022', '2022-présent'], 'fuelType' => ['Essence']],
            ['name' => 'Hilux', 'generations' => ['1968-1972', '1972-1978', '1978-1983', '1983-1988', '1988-1997', '1997-2005', '2005-2015', '2015-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);
        // --- LEXUS ---
        yield from $this->generateBrandModels('Lexus', [
            ['name' => 'IS', 'generations' => ['1998-2005', '2005-2013', '2013-2020', '2020-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'RX', 'generations' => ['1998-2003', '2003-2008', '2008-2015', '2015-2022', '2022-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'NX', 'generations' => ['2014-2021', '2021-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);

        // --- BMW ---
        yield from $this->generateBrandModels('BMW', [
            ['name' => '3', 'generations' => ['1975-1983', '1983-1990', '1990-1998', '1998-2005', '2005-2012', '2012-2019', '2019-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => '5', 'generations' => ['1972-1981', '1981-1988', '1988-1995', '1995-2003', '2003-2010', '2010-2017', '2017-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'X1', 'generations' => ['2009-2015', '2015-2022', '2022-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'X3', 'generations' => ['2003-2010', '2010-2017', '2017-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'X5', 'generations' => ['1999-2006', '2006-2013', '2013-2018', '2018-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => '1', 'generations' => ['2004-2011', '2011-2019', '2019-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => '7', 'generations' => ['1977-1986', '1986-1994', '1994-2001', '2001-2008', '2008-2015', '2015-2022', '2022-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Z4', 'generations' => ['2002-2008', '2009-2016', '2018-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);

        // --- VOLKSWAGEN ---
        yield from $this->generateBrandModels('Volkswagen', [
            ['name' => 'Golf', 'generations' => ['1974-1983', '1983-1992', '1991-1999', '1997-2003', '2003-2008', '2008-2012', '2012-2019', '2019-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Polo', 'generations' => ['1975-1981', '1981-1994', '1994-2001', '2001-2009', '2009-2017', '2017-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Passat', 'generations' => ['1973-1981', '1981-1988', '1988-1993', '1993-1996', '1996-2005', '2005-2010', '2010-2014', '2014-2023', '2023-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Tiguan', 'generations' => ['2007-2016', '2016-2024', '2024-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Touran', 'generations' => ['2003-2010', '2010-2015', '2015-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Caddy', 'generations' => ['1980-1995', '1995-2004', '2004-2015', '2015-2020', '2020-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);

        // --- MERCEDES-BENZ ---
        yield from $this->generateBrandModels('Mercedes-Benz', [
            ['name' => 'A', 'generations' => ['1997-2004', '2004-2012', '2012-2018', '2018-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'B', 'generations' => ['2005-2011', '2011-2019', '2019-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'C', 'generations' => ['1993-2000', '2000-2007', '2007-2014', '2014-2021', '2021-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'E', 'generations' => ['1993-2002', '2002-2009', '2009-2016', '2016-2023', '2023-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'S', 'generations' => ['1991-1998', '1998-2005', '2005-2013', '2013-2020', '2020-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'GLA', 'generations' => ['2013-2020', '2020-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'GLC', 'generations' => ['2015-2022', '2022-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Sprinter', 'generations' => ['1995-2006', '2006-2018', '2018-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);
        // --- AUDI ---
        yield from $this->generateBrandModels('Audi', [
            ['name' => 'A3', 'generations' => ['1996-2003', '2003-2012', '2012-2020', '2020-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'A4', 'generations' => ['1994-2001', '2001-2008', '2008-2015', '2015-2023', '2023-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'A6', 'generations' => ['1994-1997', '1997-2004', '2004-2011', '2011-2018', '2018-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Q3', 'generations' => ['2011-2018', '2018-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Q5', 'generations' => ['2008-2017', '2017-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Q7', 'generations' => ['2005-2015', '2015-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'TT', 'generations' => ['1998-2006', '2006-2014', '2014-2023'], 'fuelType' => ['Essence', 'Diesel']],
        ]);

        // --- KIA ---
        yield from $this->generateBrandModels('Kia', [
            ['name' => 'Ceed', 'generations' => ['2006-2012', '2012-2018', '2018-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Sportage', 'generations' => ['1993-2004', '2004-2010', '2010-2015', '2015-2021', '2021-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Picanto', 'generations' => ['2004-2011', '2011-2017', '2017-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Rio', 'generations' => ['2000-2005', '2005-2011', '2011-2017', '2017-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);

        // --- FORD ---
        yield from $this->generateBrandModels('Ford', [
            ['name' => 'Fiesta', 'generations' => ['1976-1983', '1983-1989', '1989-1995', '1995-2002', '2002-2008', '2008-2017', '2017-2023'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Focus', 'generations' => ['1998-2004', '2004-2011', '2011-2018', '2018-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Mondeo', 'generations' => ['1993-2000', '2000-2007', '2007-2014', '2014-2022'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Kuga', 'generations' => ['2008-2012', '2012-2019', '2019-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Transit', 'generations' => ['1965-1978', '1978-1986', '1986-2000', '2000-2014', '2014-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);

        // --- HYUNDAI ---
        yield from $this->generateBrandModels('Hyundai', [
            ['name' => 'i10', 'generations' => ['2007-2013', '2013-2019', '2019-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'i20', 'generations' => ['2008-2014', '2014-2020', '2020-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'i30', 'generations' => ['2007-2012', '2012-2017', '2017-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Tucson', 'generations' => ['2004-2009', '2009-2015', '2015-2020', '2020-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Santa Fe', 'generations' => ['2000-2006', '2006-2012', '2012-2018', '2018-2023', '2023-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);
        // --- NISSAN ---
        yield from $this->generateBrandModels('Nissan', [
            ['name' => 'Micra', 'generations' => ['1982-1992', '1992-2002', '2002-2010', '2010-2016', '2016-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Note', 'generations' => ['2004-2013', '2013-2017', '2017-présent (JDM/e-Power)'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Juke', 'generations' => ['2010-2019', '2019-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Qashqai', 'generations' => ['2007-2013', '2013-2021', '2021-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'X-Trail', 'generations' => ['2000-2007', '2007-2013', '2013-2022', '2022-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);

        // --- VOLVO ---
        yield from $this->generateBrandModels('Volvo', [
            ['name' => 'S40', 'generations' => ['1995-2004', '2004-2012'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'V60', 'generations' => ['2010-2018', '2018-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'XC60', 'generations' => ['2008-2017', '2017-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'XC90', 'generations' => ['2002-2015', '2015-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);

        // --- MINI ---
        yield from $this->generateBrandModels('MINI', [
            ['name' => 'Cooper', 'generations' => ['2001-2006', '2006-2013', '2013-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Countryman', 'generations' => ['2010-2016', '2016-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'One', 'generations' => ['2001-2006', '2006-2013', '2013-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);

        // --- JEEP ---
        yield from $this->generateBrandModels('Jeep', [
            ['name' => 'Renegade', 'generations' => ['2014-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Compass', 'generations' => ['2006-2016', '2016-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Wrangler', 'generations' => ['1986-1995', '1995-2006', '2006-2018', '2018-présent'], 'fuelType' => ['Essence', 'Diesel']],
            ['name' => 'Grand Cherokee', 'generations' => ['1992-1998', '1998-2005', '2005-2010', '2010-2021', '2021-présent'], 'fuelType' => ['Essence', 'Diesel']],
        ]);
    }
}
