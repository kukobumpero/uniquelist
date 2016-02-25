<?php
/**
 * uniquelist
 *
 * Date: 2/25/16
 * License: See LICENSE file @root_folder.
 */

namespace Bumpero\Utils;

/**
 * Class Utils
 * (could/should have extended ArrayObject but didn't.)
 * (could/should have added some error handling but didn't.)
 *
 * @package Bumpero
 *
 * Holds a multi-dimensional "array".
 * Any number of dimensions may be set to hold unique values. By default the
 *      first non numeric dimension is used as unique identifier.
 * The behavior regarding new repeating values can be customized to either
 *      remove the new value or append a sequential identifier {@default}.
 */

class UniqueList
{
    /**
     * Defines the behavior upon finding duplicates
     * Default behavior is to append a sequential identifier
     *
     * @var bool
     */
    protected $appendSequentialIdentifier = true;

    /**
     * Defines if keeps copies of current $mainList on
     *      loading/setting/re-parsing the $mainList.
     * Default behavior is to NOT keep history
     * @var bool
     */
    protected $keepHistory = false;

    /**
     * Holds the index of "unique identifier" dimension.
     *
     * @var array
     */
    protected $uniqueDimension = 0;

    /**
     * Holds the main list which is always parsed on set.
     *
     * @var array
     */
    protected $mainList = array();

    /**
     * Holds copies of previous @mainLists for "undo"/"redo" functionality.
     * @todo: implement this functionality and related methods (undo, redo etc).
     * @var array
     */
    protected $mainListHistory = array();

    /**
     * Utils constructor.
     * @param   bool    $appendSequentialIdentifier
     * @param   bool    $keepHistory
     * @param   array   $uniqueDimensions
     */
    public function __construct($appendSequentialIdentifier = true,
                                $keepHistory = false, $uniqueDimension = 0)
    {
        if ($appendSequentialIdentifier === false) {
            $this->appendSequentialIdentifier = false;
        }
        /**
         *  @todo: Change assignment to true.
         */
        if ($keepHistory === true) {
            $this->keepHistory = false;
        }
        if ($uniqueDimension > 0) {
            $this->$uniqueDimension = $uniqueDimension;
        }
    }

    /** Getters & Setters */

    /**
     * @return array
     */
    public function getMainList()
    {
        return $this->mainList;
    }

    /**
     * Setter for the $mainList.
     * By default it's always parsed.
     *
     * @param   $inputList    array()
     */
    protected function setMainList($inputList)
    {
        $this->mainList = $this->parseList($inputList);
    }

    /** Main Methods */

    /**
     * Takes the relative path to a csv file and loads.
     *
     * @param   $csvFilePath    string
     */
    public function loadFromCSVFilePath($csvFilePath)
    {
        $fileHandle = fopen($csvFilePath, 'r');
        $this->loadFromFileHandle($fileHandle);

        fclose($fileHandle);
    }

    /**
     * Loads a CSV from a file handle.
     *
     * @param $fileHandle
     */
    public function loadFromFileHandle($fileHandle)
    {
        $inputList = array();

        while (($result = fgetcsv($fileHandle)) !== false)
        {
            $inputList[] = $result;
        }

        $this->setMainList($inputList);
    }

    /**
     * Undo last load/set
     *
     * Allows using previous loaded lists/csvs.
     */
    public function undo()
    {
        /**
         * @todo: implement "undo" functionality.
         */
    }

    /**
     * Redo last Undo
     */
    public function redo()
    {
        /**
         * @todo: implement "redo" functionality.
         */
    }

    /**
     * Parses the inputList.
     *
     * Either appends sequential identifiers (default behavior) or removes duplicates.
     *
     * @param   array   $inputList
     * @return  array
     */
    protected function parseList($inputList)
    {
        $parsedList = array();

        if ($this->appendSequentialIdentifier) {
            $parsedList = $this->parseListAppendingSequentialIdentifier($inputList);
        } else {
            $parsedList = $this->parseListRemovingDuplicates($inputList);
        }

        return $parsedList;
    }

    /**
     * Parses $inputList by appending a sequential identifier.
     *
     * @param $inputList    array()
     *
     * @return array
     */
    protected function parseListAppendingSequentialIdentifier($inputList)
    {
        $parsedList = array();
        $duplicateCounter = array();

        foreach ($inputList as $row) {
            if (isset($duplicateCounter[$row[$this->uniqueDimension]])) {
                // appends the last duplicateCounter, *pre incrementing* it.
                $row[$this->uniqueDimension] .= ' - ' . ++$duplicateCounter[$row[$this->uniqueDimension]];
            } else {
                $duplicateCounter[$row[$this->uniqueDimension]] = 0;
            }
            $parsedList[] = $row;
        }

        return $parsedList;
    }

    /**
     * Parses the $inputList removing duplicates.
     *
     * @param $inputList    array()
     *
     * @return array
     */
    protected function parseListRemovingDuplicates($inputList)
    {
        $parsedList = array();
        $duplicateCounter = array();

        foreach ($inputList as $row) {
            if (!isset($duplicateCounter[$row[$this->uniqueDimension]])) {
                $parsedList[] = $row;
            }
        }

        return $parsedList;
    }
}