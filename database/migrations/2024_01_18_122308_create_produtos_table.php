<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->decimal('vazao_diaria', 8, 2);
            $table->decimal('vazao_horaria_media', 8, 2);
            $table->timestamps();
        });

        Schema::create('configuracoes', function (Blueprint $table) {

            $table->text('pdf')->nullable();

            $table->integer('padrao_alto')->default(160);

            $table->integer('padrao_medio')->default(130);

            $table->integer('padrao_baixo')->default(100);

            $table->integer('funcionario_operacao')->default(70);

            $table->integer('funcionario_admin')->default(50);

            $table->integer('refeicao')->default(25);

            $table->integer('visita')->default(2);

            $table->float('taxa_infiltracao')->default(0.01296);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
        Schema::dropIfExists('configuracoes');
    }
};
