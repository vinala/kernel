<?php 

namespace Lighty\Kernel\Console\Commands;


use Lighty\Kernel\Config\Config;
use Lighty\Kernel\Console\Command\Commands;
use Lighty\Kernel\Foundation\Application;
use Lighty\Kernel\Setup\Response;



class SetupCommand extends Commands
{

    /**
     * The key of the console command.
     *
     * @var string
     */
    protected $key = "setup";

    /**
     * The console command description.
     *
     * @var string
     */
    public $description = '';

    /**
     * Handle the command
     */
    public function handle()
    {
        $this->line("\nWelcome to Vinala Framework");
        $this->line("by Youssef Had (www.facebook.com/yussef.had)");
        $this->line("");
        $name = $this->ask("What's your name ?");
        $this->line("Welcome ".$name);
        
        //
        if( $this->confirm("\nBefore we launch $name, would you like to fill some information about your project ? [y/n] " , true) )
        {
           
            $this->line("");
            $project = $this->ask("What's your project name ?");
            $lang = $this->choice("What's your app language ?" , ['english' , 'french' , 'arab']);
            $hide = $this->confirm("Wanna hide your app from search engines ? [y/n]" , false);
            $debugging = $this->confirm("Activate debugging mode ? [y/n]" , true);
            //
            $panel = $this->confirm("\nThe framework also use a panel controle , would you like to activate it ? [y/n]" , true);
            if($panel)
            {
                $route = $this->ask("What's the panel route?");
                $password1 = $this->ask("What's the first password ?");
                $password2 = $this->ask("What's the second password ?");
                //
                Response::setPanel_step($panel, $route , $password1 , $password2);
            }
        }
        //
        Response::setGlob_step($project , $name , $lang , $debugging , $hide);
        $key1 = md5(uniqid(rand(), TRUE));
        $key2 = md5(uniqid(rand(), TRUE));
        Response::setSecur_step($key1 , $key2);
        $this->line("\nThe generated framework keys : ");
        //
        $this->write("first key : ");
        $this->info("$key1");
        $this->write("second key : ");
        $this->info("$key2");
        $this->line("\nThe framework is ready\n");
    }

    /**
     * Format the message to show
    */
    public function show()
    {
        
        
        

    }
}

