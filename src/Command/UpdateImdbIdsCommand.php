<?php

namespace App\Command;

use App\Entity\Movie;
use App\Gateway\OmdbApiGateway;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateImdbIdsCommand extends Command
{
    protected static $defaultName = 'app:update-imdb-ids';
    protected static $defaultDescription = 'Update the IMDB ids for all movies that misses it.';

    private ObjectRepository $movieRepository;
    private ObjectManager $entityManager;
    private OmdbApiGateway $omdbApiGateway;

    public function __construct(
        ManagerRegistry $registry,
        OmdbApiGateway $omdbApiGateway
    )
    {
        $this->movieRepository = $registry->getRepository(Movie::class);
        $this->entityManager = $registry->getManager();
        $this->omdbApiGateway = $omdbApiGateway;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
//            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $updateCount = 0;
        $movies = $this->movieRepository->findBy(['imdbId' => null]);

        foreach($movies as $movie) {
            $imdbId = $this->omdbApiGateway->searchForMovieIdByTitle(
                $movie->title
            );

            if($imdbId === null) {
                continue;
            }

            $updateCount++;
            $movie->imdbId = $imdbId;
            $this->entityManager->flush();


        }

        $io->success(sprintf('%d movies were updated.', $updateCount));

        return Command::SUCCESS;
    }
}
