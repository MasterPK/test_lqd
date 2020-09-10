<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Tracy\Debugger;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{

    /** @var Nette\Database\Context @inject */
    public $database;

    public function beforeRender()
    {
        
    }
}
