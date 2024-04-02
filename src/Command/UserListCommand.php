<?php

namespace App\Command;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'ninexb:user:list',
    description: 'Show Users Listing',
    aliases: ['ninexb:user:list <userID>']
)]
class UserListCommand extends Command
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('userID', InputArgument::OPTIONAL, 'UserID as optional parameter')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $userID = $input->getArgument('userID');
        $userRepository = $this->em->getRepository(Users::class);
        $rows = [];

        if ($userID) {
            $io->note(sprintf('You passed userID: %s', $userID));
        }

        if ($userID) {        
            $users = $userRepository->find($userID);
            
            if (! $users) {
                $io->error(sprintf('User with ID:%s not found!', $userID));
                return Command::INVALID;
            }

            $rows = [
                [
                    $users->getId(),
                    $users->getFirstName(),
                    $users->getLastName()
                ]
            ];
        } else {
            $users = $userRepository->findAll();

            foreach ($users as $user) {
                $rows[] = [
                    $user->getId(),
                    $user->getFirstName(),
                    $user->getLastName(),
                ];
            }
        }

        $table = new Table($output);
        $table->setHeaders(['ID', 'First Name', 'Last Name']);
        $table->setRows($rows);
        $table->render();


        return Command::SUCCESS;
    }
}
