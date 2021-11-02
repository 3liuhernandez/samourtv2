export const commons = {
    methods: {
        /**
         * Renderiza los errores
         * 
         * @param {*} list_err 
         * @param {*} errors 
         */
        parseErrors(list_err, errors){
            this.clearValues(list_err);
            for(let index in errors){
                if(list_err.hasOwnProperty(index)){
                    list_err[index] = errors[index][0];
                }
            }
        },
        /**
         * Limpia los errores 
         * 
         * @param {*} list_err 
         */
        clearValues(list_err){
            for(let i in list_err){
                list_err[i] = '';
            }
        },
        /**
         * Limita un input a sólo numeros
         * 
         * @param {*} evt 
         */
        NumbersOnly(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();;
            } else {
                return true;
            }
        },
        /**
         * Verificar si un elemento está vacio
         * 
         * @param {*} str 
         */
        is_empty(str){
          if (null == str) return true;
          str = str.replace(/ /g, '+');
          if (str.length == 0 || str == '') return true;
          return false;
      },

    },
};