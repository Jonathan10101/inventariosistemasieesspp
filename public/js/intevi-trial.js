'use strict';

document.addEventListener('livewire:init', () => {
    Livewire.hook('request', ({ fail }) => {
        fail(({ status, content, preventDefault }) => {
            const trialExpired =
                status === 402 &&
                typeof content === 'string' &&
                content.includes('INTEVI_TRIAL_EXPIRED');

            if (!trialExpired) {
                return;
            }

            preventDefault();

            window.location.href = '/suscripcion-vencida';
        });
    });
});