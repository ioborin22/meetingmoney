<template>
    <div class="overflow-x-auto">
        <table class="min-w-full table-fixed bg-white">
            <!-- Заголовки столбцов -->
            <thead class="bg-gray-100">
            <tr>
                <!-- Заголовок "Продавец" -->
                <th class="w-1/4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Продавец</th>
                <!-- Заголовок "Рейтинг" -->
                <th class="w-1/4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Рейтинг</th>
                <!-- Заголовок "Отдадите" -->
                <th class="w-1/4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Отдадите</th>
                <!-- Заголовок "Получите" -->
                <th class="w-1/4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Получите</th>
                <!-- Заголовок "Цена" -->
                <th class="w-1/4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Цена</th>
                <!-- Заголовок "Мин. - Макс." -->
                <th class="w-1/4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Мин. - Макс.</th>
                <!-- Пустой заголовок для дополнительных действий -->
                <th class="w-1/4 px-6 py-3"> </th>
            </tr>
            </thead>
            <!-- Данные о предложениях -->
            <tbody class="bg-white divide-y divide-gray-200">
            <!-- Пример строки с данными -->
            <tr v-for="(item, index) in offerListing" :key="index" class="hover:bg-gray-100">
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

<script setup>
// Принимайте offerListing как пропс
const props = defineProps({
    offerListing: Array, // Предположим, что offerListing - это массив объектов
});
</script>

<style scoped>

</style>
