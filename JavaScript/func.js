

export function dataToBRcomHora(dataAmericana) {
    if (dataAmericana == '' || dataAmericana === null  || dataAmericana == undefined) {
        return '';
    }
    const data = dataToBR(dataAmericana)
    return data
  }

  export  function dataToBR(dataAmericana) {
     
    if (dataAmericana == '' || dataAmericana === null || dataAmericana == undefined ) {
        return '';
    }

    let dt = dataAmericana.split(' ');
    return dt[0].split('-').reverse().join('/');
}
export function mascararCNPJ(valor) { 
    // alert()
    // Remover caracteres não numéricos
    let cnpj = valor.replace(/\D/g, '');

    // Adicionar a máscara
    if (cnpj.length > 2 && cnpj.length <= 5) {
        cnpj = cnpj.replace(/(\d{2})(\d{1,3})/, '$1.$2');
    } else if (cnpj.length > 5 && cnpj.length <= 8) {
        cnpj = cnpj.replace(/(\d{2})(\d{3})(\d{1,3})/, '$1.$2.$3');
    } else if (cnpj.length > 8 && cnpj.length <= 12) {
        cnpj = cnpj.replace(/(\d{2})(\d{3})(\d{3})(\d{1,4})/, '$1.$2.$3/$4');
    } else if (cnpj.length > 12) {
        cnpj = cnpj.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{1,2})/, '$1.$2.$3/$4-$5');
    }

    // Atualizar o valor do input
    return cnpj;
    // if(this.form.cnpj.length == 18){ 
    //     alert(this.validarCNPJ())
    // }
}

export function validarCNPJ(valor) {
    // Remover caracteres não numéricos
    let cnpj = valor.replace(/\D/g, '');

    // Verificar se o CNPJ possui 14 dígitos
    if (cnpj.length !== 14) {
        return false;
    }

    // Calcular os dígitos verificadores
    let soma = 0;
    let peso = 2;

    for (let i = 11; i >= 0; i--) {
        soma += parseInt(cnpj.charAt(i)) * peso;
        peso = (peso === 9 ? 2 : peso + 1);
    }

    const digitoVerificador1 = (soma % 11) < 2 ? 0 : 11 - (soma % 11);

    soma = 0;
    peso = 2;

    for (let i = 12; i >= 0; i--) {
        soma += parseInt(cnpj.charAt(i)) * peso;
        peso = (peso === 9 ? 2 : peso + 1);
    }

    const digitoVerificador2 = (soma % 11) < 2 ? 0 : 11 - (soma % 11);

    // Verificar se os dígitos verificadores estão corretos
    return (
        parseInt(cnpj.charAt(12)) === digitoVerificador1 &&
        parseInt(cnpj.charAt(13)) === digitoVerificador2
    );
}

export function mascararCPF(valor) {
    // Remover caracteres não numéricos
    let cpf = valor.replace(/\D/g, '');

    // Adicionar a máscara
    if (cpf.length > 3 && cpf.length <= 6) {
        cpf = cpf.replace(/(\d{3})(\d{1,3})/, '$1.$2');
    } else if (cpf.length > 6 && cpf.length <= 9) {
        cpf = cpf.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
    } else if (cpf.length > 9) {
        cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
    }

    // Atualizar o valor do v-model
    return cpf;
    // if (this.responsavel_cpf.length == 14) {
    //     alert(this.validarCPF(this.responsavel_cpf))
    // }
}

export function validarCPF(cpf) {
    // Remove a máscara (pontos e hífen)
    const cpfLimpo = cpf.replace(/[^\d]/g, '');

    // Verifica se tem 11 dígitos ou se é uma sequência repetida
    if (!/^\d{11}$/.test(cpfLimpo) || /^(\d)\1{10}$/.test(cpfLimpo)) {
        return false;
    }

    // Função para calcular o dígito verificador
    const calcularDigito = (cpf, fatorInicial) => {
        let soma = 0;
        for (let i = 0; i < fatorInicial - 1; i++) {
            soma += cpf[i] * (fatorInicial - i);
        }
        const resto = (soma * 10) % 11;
        return resto === 10 ? 0 : resto;
    };

    // Calcula os dois dígitos verificadores
    const digito1 = calcularDigito(cpfLimpo, 10);
    const digito2 = calcularDigito(cpfLimpo, 11);

    // Verifica se os dígitos calculados são iguais aos do CPF
    return digito1 === parseInt(cpfLimpo[9]) && digito2 === parseInt(cpfLimpo[10]);
}

export function validarCPF_old(cpf) {
    // Remover caracteres não numéricos
    cpf = cpf.replace(/\D/g, '');

    // Verificar se o CPF possui 11 dígitos
    if (cpf.length !== 11) {
        return false;
    }

    // Validar CPF
    let soma = 0;
    for (let i = 0; i < 9; i++) {
        soma += parseInt(cpf.charAt(i)) * (10 - i);
    }
    let resto = (soma * 10) % 11;

    if (resto !== parseInt(cpf.charAt(9))) {
        return false;
    }

    soma = 0;
    for (let i = 0; i < 10; i++) {
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    }
    resto = (soma * 10) % 11;

    return resto === parseInt(cpf.charAt(10));
}