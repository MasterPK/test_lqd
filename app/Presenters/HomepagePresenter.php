<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components\DataGrid;
use App\Model\DataLoader;
use Nette;
use Tracy\Debugger;
use GuzzleHttp;
use Nette\Utils\Json;

/**
 * Class HomepagePresenter
 * @package App\Presenters
 */
final class HomepagePresenter extends Nette\Application\UI\Presenter
{

    /** @var DataLoader @inject */
    public $dataLoader;

    /**
     * Redirect if logged in.
     */
    public function renderDefault()
    {
        if ($this->getUser()->isLoggedIn()) {
            $this->redirectUrl("/tabulka");
        }
    }

    /**
     * @return Nette\Application\UI\Form
     */
    public function createComponentForm()
    {
        $form = new Nette\Application\UI\Form();

        $form->addPassword("password", "Zadejte heslo:")
            ->setRequired();

        $form->addSubmit("submit");

        $form->onSuccess[] = [$this, 'formSucceeded'];

        return $form;
    }


    /**
     * @param Nette\Application\UI\Form $form
     * @param $data
     * @throws Nette\Application\AbortException
     */
    public function formSucceeded(Nette\Application\UI\Form $form, $data)
    {
        $user = $this->getUser();

        try {
            $user->login("user1", $data->password);
            $user->setExpiration('30 minutes');
            $this->redirectUrl("/tabulka");
        } catch (Nette\Security\AuthenticationException $e) {
            $this->flashMessage("Chyba! Špatné heslo.");
        }

    }


    /**
     * @throws Nette\Application\AbortException
     */
    public function renderTabulka()
    {
        if ($this->getUser()->isLoggedIn() == false) {
            $this->redirectUrl("/");
        }
    }


    /**
     * @throws Nette\Application\AbortException
     */
    public function handleLogout()
    {
        $this->getUser()->logout();
        $this->redirectUrl("/");
    }


    /**
     * Nacist data jako JSON do session
     */
    public function handleNacist()
    {
        $this->dataLoader->loadJsonFromUrlToSession("https://reqres.in/api/users?per_page=100");
    }

    public function createComponentDataGrid()
    {
        return new DataGrid($this->getSession());
    }



}
