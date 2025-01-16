const circle = document.querySelector('#circle');
let run = true;
let isJump = true;
let config= true;
// document.addEventListener('keydown', function(e)
// {
//     if(e.keyCode == 32)
//     {
//         circle.classList.add('jump');
//         // circle.onanimationend = () => {
//         //     circle.classList.remove('jump');
//         // }
//         setTimeout(function(){
//             circle.classList.remove('jump');
//         },650);
        
//     }
// });

document.addEventListener('keydown', function(e)
{
    if(e.keyCode == 32 && run == true)
    {
        
        circle.style.top = '-180px';
        setTimeout(function(){
            circle.style.top = '0px';
            
        },650);
    }
    
});

function score(){
   if(run == true){
   let scoreCounter = setInterval(function(){
        const scorePointer = document.querySelector('.score');
        scorePointer.innerHTML = (parseInt(scorePointer.innerHTML)) + 1;
            if(run == false)
            {
                clearInterval(scoreCounter);
            }
    
            
        
    },100);
}
}

score();

const tombol = document.querySelector('.tombol');
tombol.addEventListener('click', function(){
    config = false;
});

function setBoxMoving(){
    let box = document.getElementById('box');
    let boxMover = setInterval(function()
    {
        
        if (circle.offsetTop + 50 >= box.offsetTop && 
            circle.offsetLeft + 50 >= box.offsetLeft &&
            circle.offsetTop + 50 <= box.offsetTop +50 &&
            circle.offsetLeft <= box.offsetLeft + 50 || config==false)
        {
            circle.classList.remove('bulat');
            alert(`Game Over, skor anda adalah : ${document.querySelector('.score').innerHTML}`);
            run = false;
            document.getElementById('bg').style.animation = 'none';
            clearInterval(boxMover);
            

        }
        box.style.marginLeft = (parseInt(box.style.marginLeft.replace('px', ''))-1) + 'px';
        if(box.style.marginLeft  == '-1100px')
        {
            box.style.marginLeft = (110 + Math.floor(Math.random()) * 1000) + 'px';
            
        }
    },1);
    
}

setBoxMoving();



// if (circle.offsetTop + 50 >= box.offsetTop && 
//     circle.offsetLeft + 50 >= box.offsetLeft &&
//     circle.offsetTop + 50 <= box.offsetTop +50 &&
//     circle.offsetLeft <= box.offsetLeft + 50)







// function backgroundMoving(){
//     setTimeout(function(){
//         const bg = document.getElementById('bg');
//     bg.style.backgroundPosition = (parseInt(bg.style.backgroundPosition.replace('px',''))+1) + 'px';
//     }, 100);
//     backgroundMoving();
// }
// backgroundMoving();