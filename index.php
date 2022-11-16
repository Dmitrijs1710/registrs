<?php

require_once 'vendor/autoload.php';

use App\Firm;
use App\FirmCollection;

use League\Csv\Reader;

//load the CSV document from a file path
$csv = Reader::createFromPath("register.csv");
$csv->setDelimiter(';');
$csv->setHeaderOffset(0);

//parsing all data into FirmCollection object
$firms = new FirmCollection();

foreach ($csv->getRecords() as $record)
{
    $name = $record['name'];
    unset($record['name']);
    $regCode = $record['regcode'];
    unset($record['regcode']);
    $firms->add(new Firm($regCode, $name, $record));
}

//user interface
while(true){
    //selection of search type
    echo "Choice: \n";
    echo "0 to exit\n";
    echo "1 to search by name\n";
    echo "2 to search by registration code\n";
    echo "3 to search by offset\n";
    echo "4 to get count of registrations\n";
    echo "5 to get last 30\n";
    $input = (int)readline('Your choice: ');
    if ($input<=0 || $input>5)
    {
        die;
    }
    echo PHP_EOL;
    $result = [];
    //user options input for search and function calls
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
        case 5:
            $result = $firms->getByOffset($firms->getCountOfFirms()-31,30);
            break;

    }
    echo PHP_EOL;
    //result output
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