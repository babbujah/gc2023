<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateArquivoMediaTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void{
        $table = $this->table('gc_arquivo_media');
        $table->addColumn('nome', 'string', ['limit' => 256])
              ->addColumn('descricao', 'string', ['limit' => 256])
              ->addColumn('caminho_arquivo', 'string', ['limit' => 256, 'default' => NULL])
              ->addColumn('tipo_id', 'integer', ['null' => true])
              ->addColumn('data_criado', 'datetime')
              ->addColumn('hash', 'string', ['limit' => 256, 'default' => NULL])
              ->addForeignKey('tipo_id', 'gc_tipo_arquivo', 'id', ['delete' => 'SET_NULL', 'update' => 'NO_ACTION', 'constraint' => 'tipo_id_gc_arquivo_media_id_gc_tipo_arquivo'])
              ->create();
    }
}