const viPanel = document.getElementById('visually-impaired');

document.addEventListener('DOMContentLoaded', function () {
    if (currentViStatus){
        let isVI = currentViStatus === 'on';
        isVI && viPanel.classList.add('on');
    }

    document.getElementById('vi-toggle').addEventListener('click', toggleVi);
    const root = document.documentElement;
    const viButtons = document.getElementsByClassName('vi-btn');
    for (let i = 0; i < viButtons.length; i++) {
        let type = viButtons[i].dataset.type;
        let value = viButtons[i].dataset.value;

        if (currentViSettings[type] === value){
            viButtons[i].classList.add('active');
        }
        viButtons[i].addEventListener('click', (e) => {
            if (e.currentTarget.parentNode.getElementsByClassName('active').length > 0){
                e.currentTarget.parentNode.getElementsByClassName('active')[0].classList.remove('active');
            }
            e.currentTarget.classList.add('active');
            updateViSettings(type, value);
        });

    }
});

const toggleVi = () => {
    toggleMenu();
    let toggleVi = localStorage.getItem('vi') === 'on' ? 'off' : 'on';
    localStorage.setItem('vi', toggleVi);
    viPanel.classList.toggle('on');
    if (localStorage.getItem('vi') === 'on'){
        document.getElementById('vi-toggle').innerText = 'Обычная версия';
        addBodyClasses();
    } else {
        document.getElementById('vi-toggle').innerText = 'Версия для слабовидящих';
        removeBodyClasses();
    }
}

const removeBodyClasses = () => {
    document.documentElement.classList.remove('vi-on', 'font-'+currentViSettings.font, 'fontSize-'+currentViSettings.fontSize, 'bg-'+currentViSettings.bg, 'images-'+currentViSettings.images, 'fontSpacing-'+currentViSettings.fontSpacing);
}
const addBodyClasses = () => {
    document.documentElement.classList.add('vi-on', 'font-'+currentViSettings.font, 'fontSize-'+currentViSettings.fontSize, 'bg-'+currentViSettings.bg, 'images-'+currentViSettings.images, 'fontSpacing-'+currentViSettings.fontSpacing);
}
const updateViSettings = (field, value) => {
    if (currentViSettings[field] === value){
        return;
    }
    document.documentElement.classList.remove(field+'-'+currentViSettings[field]);
    currentViSettings[field] = value;
    localStorage.setItem('viSettings', JSON.stringify(currentViSettings));
    document.documentElement.classList.add(field+'-'+value);

};