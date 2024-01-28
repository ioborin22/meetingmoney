<template>
    <div class="overflow-x-auto container mx-auto p-2 sm:p-6">
        <table class="min-w-full table-fixed bg-white">
            <!-- Заголовки столбцов -->
            <thead class="bg-background-1">
            <tr>
                <!-- Заголовок "Продавец" как ссылка -->
                <th class="w-1/4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <a href="#" @click="sortBy('item.user.name')">Продавец</a>
                </th>
                <!-- Заголовок "Рейтинг" как ссылка -->
                <th class="w-1/4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <a href="#" @click="sortBy('user.rating')">Рейтинг</a>
                </th>
                <!-- Заголовок "Отдадите" как ссылка -->
                <th class="w-1/4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <a href="#" @click="sortBy('requested_token')">Отдадите</a>
                </th>
                <!-- Заголовок "Получите" как ссылка -->
                <th class="w-1/4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <a href="#" @click="sortBy('offered_token')">Получите</a>
                </th>
                <!-- Заголовок "Цена" как ссылка -->
                <th class="w-1/4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <a href="#" @click="sortBy('unit_price')">Цена</a>
                </th>
                <!-- Заголовок "Мин. - Макс." как ссылка -->
                <th class="w-1/4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <a href="#" @click="sortBy('total_price')">Мин. - Макс.</a>
                </th>
                <!-- Пустой заголовок для дополнительных действий -->
                <th class="w-1/4 px-6 py-3"> </th>
            </tr>
            </thead>
            <!-- Данные о предложениях -->
            <tbody class="bg-white divide-y divide-gray-200">
            <!-- Пример строки с данными -->
            <tr v-for="(item, index) in offerListing" :key="index" class="hover:bg-background-1">
                <!-- Ячейка с информацией о продавце -->
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <!-- Иконка онлайн/оффлайн (можно добавить логику для динамической смены цвета) -->
                            <span class="inline-block h-3 w-3 rounded-full bg-primary-red"></span>
                        </div>
                        <div class="ml-4">
                            <!-- Имя продавца -->
                            <div class="text-sm font-medium">{{ item.user.name }}</div>
                        </div>
                    </div>
                </td>
                <!-- Ячейка с информацией о рейтинге продавца -->
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5">
                        <!-- Рейтинг продавца с указанием цвета (зеленый для положительного, красный для отрицательного) -->
                        <span class="text-secondary-green">+{{ item.user.positive }}</span>
                        <span>/</span>
                        <span class="text-primary-red">-{{ item.user.negative }}</span>
                    </span>
                </td>
                <!-- Ячейка с информацией об отдаваемом токене -->
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ item.offered_token }}({{ item.offered_token_currency }})</td>
                <!-- Ячейка с информацией о получаемом токене -->
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ item.requested_token }}({{ item.requested_token_currency }})</td>
                <!-- Ячейка с информацией о цене (с указанием цвета для положительной и отрицательной цены) -->
                <td class="px-6 py-4 whitespace-nowrap text-s font-bold text-primary-green">{{ item.unit_price }}</td>
                <!-- Ячейка с информацией о минимальной и максимальной сумме -->
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ item.amount }}</td>
                <!-- Ячейка для действия "Купить" (ссылка) -->
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="#" class="inline-block px-4 py-2 border border-primary-blue text-primary-blue hover:bg-primary-blue hover:text-white hover:border-transparent rounded transition duration-150 ease-in-out">
                        {{ item.operation_type }}
                    </a>
                </td>
            </tr>
            <!-- Можно добавлять дополнительные строки с данными в цикле -->
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        offerListing: Array,
    },
    data() {
        return {
            sortByColumn: '', // Переменная для хранения выбранного столбца для сортировки
            sortDirection: 'asc', // Переменная для хранения направления сортировки (asc или desc)
        };
    },
    methods: {
        sortBy(column) {
            // Если выбранный столбец для сортировки совпадает с текущим, меняем направление сортировки
            if (this.sortByColumn === column) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                // Если выбранный столбец отличается от текущего, сбрасываем направление сортировки
                this.sortByColumn = column;
                this.sortDirection = 'asc';
            }

            // Сортируем данные в соответствии с выбранным столбцом и направлением
            this.offerListing.sort((a, b) => {
                const aValue = a[column];
                const bValue = b[column];

                // В зависимости от типа данных в столбце, сравниваем их
                if (typeof aValue === 'string' || typeof bValue === 'string') {
                    // Сортировка строк
                    return this.sortDirection === 'asc'
                        ? aValue.localeCompare(bValue)
                        : bValue.localeCompare(aValue);
                } else {
                    // Сортировка чисел
                    return this.sortDirection === 'asc'
                        ? aValue - bValue
                        : bValue - aValue;
                }
            });
        },
    },
};
</script>

<style scoped>

</style>
