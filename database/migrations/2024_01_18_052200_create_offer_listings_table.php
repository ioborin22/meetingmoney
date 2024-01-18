<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offer_listings', function (Blueprint $table) {
            $table->id(); // Автоматически создает уникальный идентификатор (ID) для каждой записи
            $table->unsignedBigInteger('user_id'); // ID пользователя/продавца
            $table->string('operation_type'); // Тип операции (покупка/продажа)

            $table->string('offered_token'); // Предлагаемый товар
            $table->string('offered_token_currency'); // Валюта предлагаемого товара

            $table->string('requested_token'); // Запрашиваемый товар
            $table->string('requested_token_currency'); // Валюта запрашиваемого товара

            $table->decimal('amount', 15, 8); // Количество криптовалюты
            $table->decimal('unit_price', 15, 2); // Цена за единицу
            $table->decimal('total_price', 15, 2); // Общая сумма сделки

            $table->string('status'); // Статус предложения
            $table->timestamp('offer_date')->nullable(); // Дата и время предложения
            $table->string('comments')->nullable(); // Комментарии/Примечания
            $table->timestamps(); // Создает два столбца: created_at и updated_at

            // Добавление внешнего ключа, который ссылается на таблицу users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Добавление индексов
            $table->index('user_id');
            $table->index('operation_type');
            $table->index('offered_token');
            $table->index('offered_token_currency');
            $table->index('requested_token');
            $table->index('requested_token_currency');
            $table->index('status');
            $table->index('offer_date');
            $table->index('comments');
            $table->index('created_at');
            $table->index('updated_at');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_listings');
    }
};
