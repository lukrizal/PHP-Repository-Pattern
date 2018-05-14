<?php

namespace App\Console\Commands;

use App\Business\Order\Repositories\RepositoryInterface as OrderRepo;
use Illuminate\Console\Command;

class Order extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:list {codes?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = <<<'EOD'
    Return the order results of the following codes if there is no inputted codes options
        0077-6495-AYUX,
        0077-6491-ASLK,
        0077-6490-VNCM,
        0077-6478-DMAR,
        0077-1456-TESV,
        0077-0836-PEFL,
        0077-0526-EBDW,
        0077-0522-QAYC,
        0077-0516-VBTW,
        0077-0424-NSHE
    , otherwise return order results based on the inputted codes 
EOD;

    /**
     * @var OrderRepo
     */
    protected $repository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(OrderRepo $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $defaultCodes = [
            '0077-6495-AYUX',
            '0077-6491-ASLK',
            '0077-6490-VNCM',
            '0077-6478-DMAR',
            '0077-1456-TESV',
            '0077-0836-PEFL',
            '0077-0526-EBDW',
            '0077-0522-QAYC',
            '0077-0516-VBTW',
            '0077-0424-NSHE'
        ];
        $codes = $this->argument('codes');
        if (empty($codes)) {
            $codes = $defaultCodes;
        } else {
            $codes = explode(',', $codes);
        }
        $this->info('Displaying order results for ' . implode(', ', $codes));

        $this->repository->find($codes);
        $this->info((string) $this->repository->render(true));
    }
}
