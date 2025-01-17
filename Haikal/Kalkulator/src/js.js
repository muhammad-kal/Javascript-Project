const display = document.querySelector('#display')
const buttons = document.querySelectorAll('button')

buttons.forEach((item) => {
    item.onclick = () =>{
        if(item.id == 'clear'){
            display.innerText = '';
        }else if(item.id == 'backspace'){
            let string = display.innerText.toString();
            display.innerText = string.substr(0, string.length - 1);
        }else if(display.innerText != '' && item.id == 'samadengan'){
            display.innerText = eval(display.innerText);
        }else if(display.innerText == '' && item.id == 'samadengan'){
            display.innerText = 'Kosong!';
            setTimeout(() => (display.innerText = ''), 2000);
        }else {
            display.innerText += item.id;
        }
    }
});

const themeSwithBtn = document.querySelector('.theme-switch');
const kalkulator = document.querySelector('.kalkulator');
const switchIcon = document.querySelector('.switch-icon');
let isDark = true;

themeSwithBtn.onclick = () => {
    kalkulator.classList.toggle('dark');
    themeSwithBtn.classList.toggle('active');
    isDark != isDark;
    
}