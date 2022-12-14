<?php

namespace App;

class FirmCollection
{
    private array $firms;

    public function __construct(array $firms = [])
    {
        foreach ($firms as $firm) {
            $this->add($firm);
        }
    }

    public function getAll(): array
    {
        return $this->firms;
    }

    public function add(Firm $firm): void
    {
        $this->firms[] = $firm;
    }

    public function searchByRegistrationCode(string $registrationCode): ?Firm
    {
        foreach ($this->firms as $firm) {
            /** @var Firm $firm */
            if ($firm->getRegistrationCode() === $registrationCode) {
                return ($firm);
            }
        }
        return null;
    }

    public function searchByName(string $name): array
    {
        $result=[];
        foreach ($this->firms as $firm) {
            /** @var Firm $firm */
            if (strpos($firm->getName(),$name)) {
                $result[] = $firm;
            }
        }
        return $result;
    }

    public function getByOffset(int $start, int $limit = 0,bool $preserve_index=true): array
    {
        if (count($this->firms) <= $start + $limit) {
            $limit = count($this->firms) - 1 - $start;
        }
        if (0 > $start) {
            return [];
        }
        $result = [];
        if($preserve_index)
        {
            for ($i = $start; $i < $start + $limit; $i++)
            {
                $result[$i] = $this->firms[$i];
            }
        } else
        {
            for ($i = $start; $i < $start + $limit; $i++)
            {
                $result[] = $this->firms[$i];
            }
        }

        return $result;
    }

    public function getCountOfFirms(): int
    {
        return count($this->firms);
    }
}