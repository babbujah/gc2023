<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void{
        $data = [
            [
                'name' => 'Admin',
                'login' => 'admin',
                'password' => '$2a$08$MTM0NzczODczNTY0ZmY2Yea5TFJSxjc22xu3S.Ns27NJHAz8j5JUy',
                'email' => 'admin@teste.com'
            ]
        ];
        
        $user = $this->table('system_user');
        $user->insert($data)
             ->saveData();
    }
}
