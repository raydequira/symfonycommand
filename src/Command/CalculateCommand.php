<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'ninexb:calculate:sum',
    description: 'Calculate the sum of the numbers in the nth row of this triangle'
)]

class CalculateCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('maxRow', InputArgument::REQUIRED, 'Argument description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $maxRow = $input->getArgument('maxRow');

        if ($maxRow) {
            $io->note(sprintf('You passed an argument: %s', $maxRow));
        }

        if ($maxRow >= 100 
            || $maxRow < 1
            || ! is_numeric($maxRow)
        ) {
            $io->error('Argument must be less than or equal to 10');
            return Command::INVALID;
        }

        $start  = 1;
        $number = 1;
        for ($row = 1; $row <= $maxRow ; $row++) {
            $col    = 0;
            $total  = 0;
            while ( $col < $row) {                
                if ($number % 2 !== 0) {
                    echo $number . " ";
                    $total += $number;
                    $col++;       
                }
                $number++;        
            }            
            echo " = ". $total ."\r\n";
        }

        $io->success('Completed!');

        return Command::SUCCESS;
    }
}
