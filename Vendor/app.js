const prevBtns = document.querySelectorAll('.btn-previous');
const nextBtns = document.querySelectorAll('.btn-next');
const progress = document.getElementById('progress');
const formSteps = document.querySelectorAll('.form-step');
const progressSteps = document.querySelectorAll('.progress-step');

let formStepNum = 0;

nextBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        formStepNum++;
        updateFormSteps();
        updateProgressbar();
    });
});

prevBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        formStepNum--;
        updateFormSteps();
        updateProgressbar();
    });
});

function updateFormSteps() {
    formSteps.forEach(formStep => {
        formStep.classList.contains('active') && formStep.classList.remove('active');
    });
    formSteps[formStepNum].classList.add('active');
}

function updateProgressbar() {
    progressSteps.forEach((step, idx) => {
        step.classList.toggle('active', idx <= formStepNum);
        step.style.backgroundColor = idx < formStepNum 
            ? '#11ce1b' // Green
            : idx === formStepNum 
                ? '#0000ff' // Blue
                : '#dcdcdc'; // Default
    });

    const progressActiveCount = document.querySelectorAll('.progress-step.active').length;
    progress.style.width = ((progressActiveCount - 1) / (progressSteps.length - 1)) * 100 + '%';
}