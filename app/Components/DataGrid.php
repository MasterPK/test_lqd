<?php


namespace App\Components;

use Nette;
use Tracy\Debugger;

class DataGrid extends Nette\Application\UI\Control
{

    /** @var array */
    private $dataSource;

    private $section;

    function __construct(Nette\Http\Session $session)
    {
        $section = $session->getSection("datagrid");
        $this->section=$section;


        $this->dataSource=$section->dataSource;

    }

    public function render(): void
    {
        $this->template->data = $this->dataSource["data"];
        $this->template->render(__DIR__ . '/datagrid.latte');
    }

    public function handleDelete($id)
    {
        Debugger::barDump($this->dataSource);

        foreach ($this->dataSource["data"] as $row)
        {
            if($row["id"]==$id)
            {
                unset($this->dataSource["data"][$id-1]);
                break;
            }
        }

        Debugger::barDump($this->dataSource);
        $this->section->dataSource=$this->dataSource;
    }

}