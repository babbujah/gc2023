<?php


use Phinx\Seed\AbstractSeed;

class TipoArquivoMediaSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
     // foto, vídeo_atividade, video_entrevista, boletim, diversos
    public function run(): void{
        $data = [
            [
                'nome' => 'foto'
            ],
            [
                'nome' => 'vídeo_atividade'
            ],
            [
                'nome' => 'video_entrevista'
            ],
            [
                'nome' => 'boletim'
            ],
            [
                'nome' => 'diversos'
            ]
        ];
        
        $tipoArquivo = $this->table('gc_tipo_arquivo');
        $tipoArquivo->insert($data)
                    ->saveData();
    }
}
