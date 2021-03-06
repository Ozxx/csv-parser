<?php
/**
 * Created by PhpStorm.
 * User: d2.kozlovsky
 * Date: 6.9.17
 * Time: 15.57
 */

namespace AppBundle\Services\Parsers;

use League\Csv\Reader;
use League\Csv\Statement;

class CsvParser implements Parser
{
    private $reader;
    private $records;
    private $entity;
    private $processed = 0;
    private $items = [];
    private $mapping;

    public function __construct(array $mapping, $entity)
    {
        $this->entity = $entity;
        $this->mapping = $mapping;
    }

    /**
     * @param string $filePath
     */
    public function setPath(string $filePath) : void
    {
        $this->reader = Reader::createFromPath($filePath);
        $this->reader->setHeaderOffset(0);
        $this->records = (new Statement())->process($this->reader);
    }

    /**
     *
     */
    public function parse() : void
    {
        foreach ($this->records as $record) {
            $item = new $this->entity();

            foreach ($this->mapping as $fileHeaders => $objectProperty) {
                $action = 'set' . $objectProperty;
                if ($fileHeaders === 'Discontinued') {
                    if (strnatcasecmp($record[$fileHeaders], 'yes') === 0) {
                        $item->$action(new \DateTime('now'));
                    } else {
                        $item->$action(null);
                    }
                } else {
                    $item->$action($record[$fileHeaders]);
                }
            }

            array_push($this->items, $item);
            ++$this->processed;
        }
    }

    /**
     * @return int
     */
    public function getProcessedCount() : int
    {
        return $this->processed;
    }

    /**
     * @return array
     */
    public function getItems() : array
    {
        return $this->items;
    }
}