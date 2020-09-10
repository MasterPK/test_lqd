<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Tracy\Debugger;


/**
 * Class HomepagePresenter
 * @package App\Presenters
 */
final class HomepagePresenter extends Nette\Application\UI\Presenter
{

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

        $form->addPassword("password","Zadejte heslo:")
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
            $user->login("user1",$data->password);
            $user->setExpiration('30 minutes');
            $this->redirectUrl("/tabulka");
        } catch (Nette\Security\AuthenticationException $e) {
            $this->flashMessage("Chyba! Špatné heslo.");
        }

    }


    public function renderTabulka()
    {
        if($this->getUser()->isLoggedIn() == false)
        {
            $this->redirectUrl("/");
        }
    }

    public function handleLogout()
    {
        $this->getUser()->logout();
        $this->redirectUrl("/");
    }


}
