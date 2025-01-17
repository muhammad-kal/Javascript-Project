function getPilihanComputer()
{
    const comp = Math.round(Math.random() * 100);
    if(comp < 34) return 'kertas';
    if(comp > 33 && comp < 66) return 'batu';
    return 'gunting';
}

let komputerValue = 0;
let playerValue = 0;

function getHasil(comp, player){
    if (comp == 'gunting')
    {
        if(player == 'gunting') return 'Seri!';
        if(player == 'batu') 
            {   playerValue+=10;
                //console.log("Komputer :" + komputerValue + ", Player :" + playerValue);
                return 'Menang!';}
        if(player == 'kertas')
        {
               komputerValue+=10;
               //console.log("Komputer :" + komputerValue + ", Player :" + playerValue);
                return 'Kalah!';
        } 
    }
    else if (comp == 'batu')
    {
        if(player == 'gunting') 
        {
            komputerValue+=10;
            //console.log("Komputer :" + komputerValue + ", Player :" + playerValue);
             return 'Kalah!';
        }
        if(player == 'batu') return 'Seri!';
        if(player == 'kertas') 
        {   playerValue+=10;
            //console.log("Komputer :" + komputerValue + ", Player :" + playerValue);
            return 'Menang!';}
    }
    else {
        if(player == 'gunting') 
        {   playerValue+=10;
            //console.log("Komputer :" + komputerValue + ", Player :" + playerValue);
            return 'Menang!';}
        if(player == 'batu') 
        {
            komputerValue+=10;
            //console.log("Komputer :" + komputerValue + ", Player :" + playerValue);
             return 'Kalah!';
        }
        if(player == 'kertas') return 'Seri!'; 
    }

    //VERSI Ringkas
    // if(comp == player) return 'SERI!';
    // if(player == 'kertas') return (comp == 'gunting') ? 'KALAH!' : 'MENANG!';
    // if(player == 'batu') return (comp == 'gunting') ? 'MENANG!' : 'KALAH!';
    // if(player == 'gunting') return (comp == 'batu') ? 'KALAH!' : 'MENANG!';
}

// const pKertas = document.querySelector('.kertas');
// pKertas.addEventListener('click', function(){
//     const pilihanKomputer = getPilihanComputer();
//     const pilihanPlayer = 'kertas';
//     const hasil = getHasil(pilihanKomputer, pilihanPlayer);
//     // console.log(pilihanKomputer + ": Komputer");
//     // console.log(pilihanPlayer + ": Player");
//     // console.log('Hasil : ' + hasil);

//     //Tampilan Pilihan Komputer
//     const gantiGambar = document.querySelector('.img-komputer');
//     gantiGambar.setAttribute('src', pilihanKomputer+'.png');

    
//     //Tampilan Hasil    
//     const tampilHasil = document.querySelector('.info')
//     tampilHasil.innerHTML =hasil;
// })

function putar(){
    const gambarComp = document.querySelector('.img-komputer');
    const gambar = ['kertas', 'batu', 'gunting'];
    let i = 0;
    const waktuMulai = new Date().getTime();
    setInterval(function(){
        if(new Date().getTime() - waktuMulai > 1000)
        {
            clearInterval;
            return;
        }
            gambarComp.setAttribute('src', gambar[i++] +'.png');
            if(i == gambar.length) i=0;
        
    }, 100)
}

let skorKomputer = document.querySelector('.nilaiSkorKomputer');
let skorPlayer = document.querySelector('.nilaiSkorPlayer');
    

const pilihan = document.querySelectorAll('li img');
pilihan.forEach(function(pilih)
{
    pilih.addEventListener('click', function(){
        const pilihanKomputer = getPilihanComputer();
        const pilihanPlayer = pilih.className;
        const hasil = getHasil(pilihanKomputer, pilihanPlayer);
        // console.log(pilihanKomputer + ": Komputer");
        // console.log(pilihanPlayer + ": Player");
        // console.log('Hasil : ' + hasil);

        putar();
        let tampilHasilSementara = document.querySelector('.info');
        tampilHasilSementara.innerHTML = "....";
        setTimeout(function()
        {
        //Tampilan Pilihan Komputer
        const gantiGambar = document.querySelector('.img-komputer');
        gantiGambar.setAttribute('src', pilihanKomputer + '.png');

        //TampilanSkor
        skorKomputer.innerHTML = komputerValue;
        skorPlayer.innerHTML = playerValue;


        //Tampilan Hasil    
        const tampilHasil = document.querySelector('.info')
        tampilHasil.innerHTML = hasil;
        },1000);
    })
});
