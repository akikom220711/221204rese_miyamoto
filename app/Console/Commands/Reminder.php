<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Reserve;
use App\Mail\ReminderMail;

class Reminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'command for send reminder mail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reserves = Reserve::all();
        $today = date('Y-m-d');

        foreach($reserves as $reserve){
            if($reserve->date == $today){
                $name = $reserve->user->name;
                $address = $reserve->user->email;
                $shop_name = $reserve->shop->shop_name;
                $date = $reserve->date;
                $time = $reserve->time;
                $number = $reserve->number;
                Mail::send(new ReminderMail($name, $address, $shop_name, $date, $time, $number));
            }
        }

    }
}
