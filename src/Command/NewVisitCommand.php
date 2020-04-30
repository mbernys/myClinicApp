<?php

namespace App\Command;

use App\Repository\VisitRepository;
use App\Entity\Visit;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class NewVisitCommand extends Command
{
    protected static $defaultName = 'app:next-visit';

    private $visitRepository;
    private $mailer;
    private $twig;

    public function __construct(VisitRepository $visitRepository, \Swift_Mailer $mailer, \Twig\Environment $twig)
    {
        parent::__construct();
        $this->visitRepository = $visitRepository;
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    protected function configure()
    {
        $this ->setDescription('Send notification about next visits');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $visits = $this->visitRepository->findNextVisit(new \DateTime());

        /** @var Visit $visit */
        foreach ($visits as $visit){
            $message = (new \Swift_Message('Hello email'))
                ->setTo($visit->getPatient()->getEmail())
                ->setBody(
                    $this->twig->render('email/next-visit.html.twig',[
                        'visit' => $visit
                    ])
                );
            $this->mailer->send($message);

        }

        $io->success(sprintf('Success send %d emails.', count($visits)));

        return 0;
    }
}
