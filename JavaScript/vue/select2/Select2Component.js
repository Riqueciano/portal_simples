
const {
    ref,
    onMounted,
    onUnmounted
} = Vue;

export const Select2Component = {
    template:  `  
        <select ref="selectElement" class="select-box" v-model="selected">
            <option value="">Selecione</option>
            <option v-for="(option, index) in options" :key="index" :value="option.id">{{ option.text?.toUpperCase() }}</option>
        </select>
    `,
    props: ['options', 'selected'],
    mounted() {
        const self = this;
        $(this.$refs.selectElement).select2({
            width: '100%',
            dropdownParent: $(this.$refs.selectElement).parent(),
            placeholder: 'Digite para filtrar',
            allowClear: false
        }).on('change', function () {
            self.$emit('update:modelValue', $(this).val());
        });
// alert(this.selected)
        this.setSelectValue(this.selected); // Define o valor selected ao montar o componente
    },
    beforeUnmount() {
        $(this.$refs.selectElement).select2('destroy');
    },
    watch: {
        selected(newValue) {
            this.setSelectValue(newValue); // Atualiza o valor selected quando a propriedade selected for alterada externamente
        }
    },
    methods: {
        setSelectValue(value) {
            $(this.$refs.selectElement).val(value).trigger('change.select2');
        }
    }
};

// Exportando o componente para utilização externa
if (typeof exports === 'object') {
    module.exports = Select2Component;
} else {
    window.Select2Component = Select2Component;
}
 
