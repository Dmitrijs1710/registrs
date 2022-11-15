<?php

require_once 'vendor/autoload.php';

use App\Firm;
use App\FirmCollection;

use League\Csv\Reader;

//load the CSV document from a file path
$csv = Reader::createFromPath("register.csv");
$csv->setDelimiter(';');
$csv->setHeaderOffset(0);

$firms = new FirmCollection();

foreach ($csv->getRecords() as $record)
{
    $name = $record['name'];
    unset($record['name']);
    $regCode = $record['regcode'];
    unset($record['regcode']);
    $firms->add(new Firm($regCode, $name, $record));
}
foreach ($firms->getByOffset($firms->getCountOfFirms()-31, 30) as $firm)
{
    /** @var Firm $firm */
    echo $firm . PHP_EOL;
}





