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
while(true){
    echo "Choice: \n";
    echo "0 to exit\n";
    echo "1 to search by name\n";
    echo "2 to search by registration code\n";
    echo "3 to search by offset\n";
    echo "4 to get count of registrations\n";
    $input = (int)readline('Your choice: ');
    if ($input<=0 || $input>4)
    {
        die;
    }
    echo PHP_EOL;
    $result = [];
    switch($input)
    {
        case 1:
            $inputName=readline('Input name to search: ');
            $result = $firms->searchByName($inputName);
            break;
        case 2:
            $inputRegistrationCode=readline('Input registration code to search: ');
            $result = $firms->searchByRegistrationCode($inputRegistrationCode);
            break;
        case 3:
            while(true)
            {
                $inputStart = (int)readline('Input offset: ');
                if($inputStart<0 || $inputStart >= $firms->getCountOfFirms())
                {
                    echo "incorrect offset\n";
                } else
                {
                    break;
                }
            }
            while(true)
            {
                $inputLimit = (int)readline('Input limit: ');
                if ($inputLimit < 0){
                    echo "incorrect limit\n";
                } else
                {
                    break;
                }
            }
            $result = $firms->getByOffset($inputStart,$inputLimit);
            break;
        case 4:
            $result = $firms->getCountOfFirms();
            break;
    }
    echo PHP_EOL;
    if(gettype($result) === 'array')
    {
        if(count($result) === 0)
        {
            echo "nothing to show\n";
        } else
        {
            echo "Search results: \n\n";
        }
        foreach ($result as $key=>$firm)
        {
            echo "$key: $firm\n";
        }
    } else
    {
        echo "Number of results of records: $result\n";
    }
    echo PHP_EOL;
}






