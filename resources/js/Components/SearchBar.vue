<template>
    <div class="shadow-lg rounded-lg mb-4">

        <!-- Tabs for switching -->
        <div class="flex p-2 space-x-1 bg-white" role="tablist">
            <button
                class="w-full p-2 text-black-500 border-b-4 border-transparent hover:border-white focus:border-blue-500"
                :class="{'border-blue-500 bg-white': tab === 'buy'}"
                @click="tab = 'buy'">
                ПОКУПКА
            </button>
            <button
                class="w-full p-2 text-black-500 border-b-4 border-transparent hover:border-white focus:border-blue-500"
                :class="{'border-blue-500 bg-white': tab === 'sell'}"
                @click="tab = 'sell'">
                ПРОДАЖА
            </button>
        </div>

        <!-- Content for BUY tab -->
        <div v-show="tab === 'buy'" class="p-4 bg-white">
            <div class="flex space-x-2">
                <input class="flex-1 form-input" type="text" placeholder="Количество"/>

                <!-- Выпадающий список для выбора платежной системы -->
                <select class="form-select" v-model="selectedPaymentSystem">
                    <optgroup label="Криптовалюты" v-if="paymentOptions.cryptocurrencies">
                        <option v-for="(supportsCurrency, crypto) in paymentOptions.cryptocurrencies" :key="crypto">
                            {{ crypto }}
                        </option>
                    </optgroup>
                    <optgroup label="Банки" v-if="paymentOptions.banks">
                        <option v-for="(supportsCurrency, bank) in paymentOptions.banks" :key="bank">
                            {{ bank }}
                        </option>
                    </optgroup>
                    <optgroup label="Платежные системы" v-if="paymentOptions.paymentSystems">
                        <option v-for="(supportsCurrency, system) in paymentOptions.paymentSystems" :key="system">
                            {{ system }}
                        </option>
                    </optgroup>
                    <optgroup label="Денежные переводы" v-if="paymentOptions.moneyTransfers">
                        <option v-for="(supportsCurrency, transfer) in paymentOptions.moneyTransfers" :key="transfer">
                            {{ transfer }}
                        </option>
                    </optgroup>
                </select>

                <!-- Выпадающий список для выбора валюты -->
                <select class="form-select" v-if="shouldShowCurrency()">
                    <option v-for="(name, code) in availableCurrencies" :key="code" :value="code">
                        {{ code }}
                    </option>
                </select>

                <button class="bg-blue-500 text-white p-2">ПОИСК</button>
            </div>
        </div>


        <!-- Content for SELL tab -->
        <div v-show="tab === 'sell'" class="p-4 bg-white">
            <div class="flex space-x-2">
                <input class="flex-1 form-input" type="text" placeholder="Количество"/>

                <!-- Выпадающий список для выбора платежной системы -->
                <select class="form-select" v-model="selectedPaymentSystem">
                    <optgroup label="Криптовалюты" v-if="paymentOptions.cryptocurrencies">
                        <option v-for="(supportsCurrency, crypto) in paymentOptions.cryptocurrencies" :key="crypto">
                            {{ crypto }}
                        </option>
                    </optgroup>
                    <optgroup label="Банки" v-if="paymentOptions.banks">
                        <option v-for="(supportsCurrency, bank) in paymentOptions.banks" :key="bank">
                            {{ bank }}
                        </option>
                    </optgroup>
                    <optgroup label="Платежные системы" v-if="paymentOptions.paymentSystems">
                        <option v-for="(supportsCurrency, system) in paymentOptions.paymentSystems" :key="system">
                            {{ system }}
                        </option>
                    </optgroup>
                    <optgroup label="Денежные переводы" v-if="paymentOptions.moneyTransfers">
                        <option v-for="(supportsCurrency, transfer) in paymentOptions.moneyTransfers" :key="transfer">
                            {{ transfer }}
                        </option>
                    </optgroup>
                </select>

                <!-- Выпадающий список для выбора валюты -->
                <select class="form-select" v-if="shouldShowCurrency()">
                    <option v-for="(name, code) in availableCurrencies" :key="code" :value="code">
                        {{ code }}
                    </option>
                </select>

                <button class="bg-blue-500 text-white p-2">ПОИСК</button>
            </div>
        </div>

    </div>
</template>

<script>
import paymentOptions from '../data/payments';
import currencies from '../data/currencies';

export default {
    data() {
        return {
            tab: 'buy', // Текущая вкладка
            selectedPaymentSystem: null, // Выбранная платежная система
            paymentOptions: paymentOptions, // Опции платежных систем
            availableCurrencies: currencies, // Доступные валюты
        };
    },
    mounted() {
        this.setDefaultPaymentSystem();
    },
    methods: {
        // Установка первой платежной системы по умолчанию
        setDefaultPaymentSystem() {
            for (let category in this.paymentOptions) {
                for (let system in this.paymentOptions[category]) {
                    this.selectedPaymentSystem = system;
                    return; // Выходим из цикла после установки первой системы
                }
            }
        },
        // Определяем, должен ли отображаться выбор валюты
        shouldShowCurrency() {
            if (!this.selectedPaymentSystem) return false;
            for (let category in this.paymentOptions) {
                if (this.paymentOptions[category][this.selectedPaymentSystem]) {
                    return true;
                }
            }
            return false;
        }
    }
};
</script>


<style>

</style>
