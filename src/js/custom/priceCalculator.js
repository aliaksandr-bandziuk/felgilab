export function initPriceCalculatorBlock() {
  const calculators = document.querySelectorAll('.price-calculator-block .calculator');

  if (!calculators.length) return;

  calculators.forEach((calculator) => {
    if (calculator.dataset.calculatorReady === 'true') return;
    calculator.dataset.calculatorReady = 'true';

    const vatRate = parseFloat(calculator.dataset.vatRate || '23');
    const wheelsCount = parseInt(calculator.dataset.wheelsCount || '4', 10);
    const currency = (calculator.dataset.currency || 'PLN').trim();

    let prices = {};

    try {
      prices = JSON.parse(calculator.dataset.prices || '{}');
    } catch (error) {
      console.error('Price calculator: invalid prices JSON', error);
      prices = {};
    }

    const submitButton = calculator.querySelector('.js-calc-submit');
    const resultBlock = calculator.querySelector('.js-calc-result');
    const appointmentButton = calculator.querySelector('.js-calc-appointment');

    const nettoOutput = calculator.querySelector('.js-calc-netto');
    const bruttoOutput = calculator.querySelector('.js-calc-brutto');
    const perWheelOutput = calculator.querySelector('.js-calc-per-wheel');

    const hiddenFields = {
      size: calculator.querySelector('.js-calc-hidden-size'),
      method: calculator.querySelector('.js-calc-hidden-method'),
      cnc: calculator.querySelector('.js-calc-hidden-cnc'),
      vulcan: calculator.querySelector('.js-calc-hidden-vulcan'),
      netto: calculator.querySelector('.js-calc-hidden-netto'),
      brutto: calculator.querySelector('.js-calc-hidden-brutto'),
      perWheel: calculator.querySelector('.js-calc-hidden-per-wheel'),
    };

    const getCheckedValue = (selector) => {
      const checkedInput = calculator.querySelector(`${selector}:checked`);
      return checkedInput ? checkedInput.value : '';
    };

    const roundPrice = (value) => {
      return Math.round((Number(value) + Number.EPSILON) * 100) / 100;
    };

    const formatPrice = (value) => {
      const rounded = roundPrice(value);

      if (Number.isInteger(rounded)) {
        return `${rounded} ${currency}`;
      }

      return `${rounded.toFixed(2).replace(/\.?0+$/, '')} ${currency}`;
    };

    const calculate = () => {
      const size = getCheckedValue('.js-calc-size');
      const method = getCheckedValue('.js-calc-method') || 'system';
      const cnc = getCheckedValue('.js-calc-cnc') || 'no';
      const vulcan = getCheckedValue('.js-calc-vulcan') || 'no';

      if (!size || !prices[size]) {
        return null;
      }

      const sizePrices = prices[size];

      let bruttoTotal = Number(sizePrices[method] || 0);

      if (cnc === 'yes') {
        bruttoTotal += Number(sizePrices.cnc || 0);
      }

      if (vulcan === 'yes') {
        bruttoTotal += Number(sizePrices.vulcan || 0);
      }

      const vatMultiplier = 1 + vatRate / 100;
      const nettoTotal = vatMultiplier > 0 ? bruttoTotal / vatMultiplier : bruttoTotal;
      const perWheelBrutto = wheelsCount > 0 ? bruttoTotal / wheelsCount : bruttoTotal;

      return {
        size,
        method,
        cnc,
        vulcan,
        brutto: roundPrice(bruttoTotal),
        netto: roundPrice(nettoTotal),
        perWheel: roundPrice(perWheelBrutto),
      };
    };

    const updateHiddenFields = (result) => {
      if (!result) return;

      if (hiddenFields.size) hiddenFields.size.value = result.size;
      if (hiddenFields.method) hiddenFields.method.value = result.method;
      if (hiddenFields.cnc) hiddenFields.cnc.value = result.cnc;
      if (hiddenFields.vulcan) hiddenFields.vulcan.value = result.vulcan;
      if (hiddenFields.netto) hiddenFields.netto.value = String(result.netto);
      if (hiddenFields.brutto) hiddenFields.brutto.value = String(result.brutto);
      if (hiddenFields.perWheel) hiddenFields.perWheel.value = String(result.perWheel);
    };

    const renderResult = (result) => {
      if (!result) return;

      if (nettoOutput) nettoOutput.textContent = formatPrice(result.netto);
      if (bruttoOutput) bruttoOutput.textContent = formatPrice(result.brutto);
      if (perWheelOutput) perWheelOutput.textContent = formatPrice(result.perWheel);

      updateHiddenFields(result);

      if (resultBlock) {
        resultBlock.classList.remove('d-none');
      }

      if (appointmentButton) {
        appointmentButton.classList.remove('d-none');
      }
    };

    const resetResult = () => {
      if (nettoOutput) nettoOutput.textContent = '';
      if (bruttoOutput) bruttoOutput.textContent = '';
      if (perWheelOutput) perWheelOutput.textContent = '';

      if (resultBlock) {
        resultBlock.classList.add('d-none');
      }

      if (appointmentButton) {
        appointmentButton.classList.add('d-none');
      }
    };

    const optionInputs = calculator.querySelectorAll(
      '.js-calc-size, .js-calc-method, .js-calc-cnc, .js-calc-vulcan'
    );

    optionInputs.forEach((input) => {
      input.addEventListener('change', () => {
        resetResult();
      });
    });

    if (submitButton) {
      submitButton.addEventListener('click', () => {
        const result = calculate();
        renderResult(result);
      });
    }
  });
}

document.addEventListener('DOMContentLoaded', () => {
  initPriceCalculatorBlock();
});