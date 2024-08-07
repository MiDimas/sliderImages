<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/src/css/reset.css?v=1">
    <link rel="stylesheet" href="/src/css/global.css?v=1">
    <link rel="stylesheet" href="/src/css/pages/demonstration.css?v=1">
</head>
<body style="overflow: hidden">
<div class="cont">
    <div class="slider" id="slider" style="opacity=100%; transition:1s;">

    </div>
</div>
<script>

    const folderName = 'img';
    function foo(){
        const arrImgElem = [];
        const arrFoldElem = [];
        slider.innerHTML = 0;
        fetch("/system/api/get-image.php", {
            method: "POST",
            body: JSON.stringify({page: folderName})
        })
            .then(r=>r.json())
            .then(data => {

                const arrImg = JSON.parse(data['arrImg']);

                let arrFoldersImg;
                if(data['arrFoldersImg']) {
                    arrFoldersImg = JSON.parse(data['arrFoldersImg']);
                }
                // console.log(arrFoldersImg);
                //  console.log(arrImg);
                for(let img of arrImg){

                    const myImg = document.createElement("img");
                    myImg.src = `/src/${folderName}/${img}`;
                    console.log(myImg.naturalHeight);
                    if(myImg.naturalHeight > myImg.naturalWidth){
                        myImg.style.cssText = `
                    display: none;
                    opacity: 100%;
                    transition: 1s;
                `;
                        myImg.style.height = "100%";
                        myImg.style.width = "auto";

                        console.log("h");
                    }
                    else{
                        myImg.style.cssText = `
                        height:auto;
                        width:100%;
                        display: none;
                    opacity: 100%;
                    transition: 1s;
                    `;
                        console.log("w");
                    }



                    arrImgElem.push(myImg);
                    slider.append(myImg);

                }
                if(arrFoldersImg) {
                    // Добавление сеток изображений
                    Object.keys(arrFoldersImg).forEach((value) => {
                        const divGridImg = document.createElement("div");
                        divGridImg.style.cssText = `
                        display: none;
                        justify-content: flex-start;
                        flex-wrap: wrap;
                    `;

                        //Проверка на количество элементов в папке приведение к стандартному количеству(4)
                        if (!arrFoldersImg[value].length) {
                            return;
                        }
                        if (arrFoldersImg[value].length > 4) {
                            arrFoldersImg[value] = arrFoldersImg[value].slice(0, 4);
                        } else if (arrFoldersImg[value].length < 4) {
                            let countElem = 0;
                            const maxCountElem = arrFoldersImg[value].length;
                            while (arrFoldersImg[value].length < 4) {
                                arrFoldersImg[value].push(arrFoldersImg[value][countElem]);
                                countElem++;
                                if (countElem >= maxCountElem) {
                                    countElem = 0;
                                }
                            }
                        }
                        //Конец проверок на количество элементов в папках
                        //Размещение элементов из папок сеткой из 4х элементов
                        for (let img of arrFoldersImg[value]) {
                            const divDescCont = document.createElement('div');
                            const spanCont = document.createElement('span');
                            const spanDesc = document.createElement('span');
                            const divBase = document.createElement("div");
                            const myImg = document.createElement("img");
                            myImg.src = `/src/${folderName}/${value}/${img}`;
                            divBase.style.cssText = `
                            flex-basis: 50%;
                            position: relative;
                        `;
                            myImg.style.cssText = `
                            height: 50vh;
                            width: 100%;
                            transition: all 1s ease;
                        `;
                            divDescCont.style.cssText = `
                            position: absolute;
                            top: 0px;
                            left: 0px;
                            width: 100vw;
                            z-index: 3;
                            display: flex;
                            justify-content: center;
                        `;
                            spanCont.style.cssText = `
                            background-color: #0000003f;
                            border-radius: 0 0 30px 30px;
                            padding: 20px 30px;
                            text-align: center;
                        `;
                            spanDesc.style.cssText = `
                            font-size: 4rem;
                            font-weight: 900;
                            color: white;
                            font-family: 'Montserrat', sans-serif;
                        `;
                            spanDesc.innerText = `${value}`;
                            divBase.append(myImg);
                            spanCont.append(spanDesc);
                            divDescCont.append(spanCont);
                            divGridImg.append(divBase, divDescCont);
                        }
                        //Конец раззмещения элементов
                        arrFoldElem.push(divGridImg);
                        slider.append(divGridImg);
                        //    Конец размещения слайда
                    });
                }


                let count = 0;
                let countFolder = 0;
                //Время анимации цельного слайда сеточные слайды в 5 раз дольше(каждый слайд по такому же количеству времени)
                let animTime = 15000;
                let animaFolder = false;
                let maxImg = arrImgElem.length;
                let maxFolder = arrFoldElem.length;

                function fullScreen(element) {
                    if(element.requestFullscreen) {
                        element.requestFullscreen();
                    } else if(element.webkitrequestFullscreen) {
                        element.webkitRequestFullscreen();
                    } else if(element.mozRequestFullscreen) {
                        element.mozRequestFullScreen();
                    }
                }
                onclick = ()=>{

                    fullScreen(slider);

                }


                function renderImg(){
                    arrImgElem[count].style.display = "none";
                    if(arrFoldElem.length){
                        arrFoldElem[countFolder].style.display = "none";
                    }
                    count++;
                    if(count >= maxImg){
                        count = 0;
                    }
                    arrImgElem[count].style.display = "block";
                    if(arrImgElem[count].naturalHeight >arrImgElem[count].naturalWidth){
                        arrImgElem[count].style.height = "100%";
                        arrImgElem[count].style.width = "auto";

                        console.log("h");
                    }
                }
                function renderFolder(){
                    arrImgElem[count].style.display = "none";
                    countFolder++;
                    if(countFolder >= maxFolder){
                        countFolder = 0;
                    }
                    arrFoldElem[countFolder].style.display = "flex";

                    const images = arrFoldElem[countFolder].getElementsByTagName('img');
                    let minImagesCount = 0;
                    const maxMinImageCount = images.length;
                    let isFullSize = false;
                    function callbackTimeoutResize () {
                        if(minImagesCount >= maxMinImageCount){
                            minImagesCount = 0;
                            return;
                        }
                        if(!isFullSize){
                            isFullSize = true;
                            fullSizeGrid(images[minImagesCount], minImagesCount);
                            setTimeout(callbackTimeoutResize, animTime/4);
                        }
                        else{
                            isFullSize=false;
                            minSizeGrid(images[minImagesCount]);
                            minImagesCount++;
                            setTimeout(callbackTimeoutResize, animTime/7);
                        }
                    }
                    setTimeout(callbackTimeoutResize, animTime/7)
                }
                renderImg();
                function callbackTimeout() {
                    if(count % Math.floor(arrImgElem.length/12) === 0 && !animaFolder && arrFoldElem.length){
                        animaFolder = true;
                        console.log("кратное");
                        renderFolder();
                        setTimeout(callbackTimeout, animTime*1.7)
                    }
                    else {
                        animaFolder = false;
                        renderImg();
                        setTimeout(callbackTimeout, animTime)
                    }
                }
                function fullSizeGrid(elem, countElem) {
                    elem.style.zIndex = "1";
                    elem.style.position = 'absolute';
                    elem.style.width = `100vw`;
                    elem.style.height= `100vh`;
                    switch (countElem){
                        case 1: elem.style.transform= `translateX(-50%)`;
                            break;
                        case 2: elem.style.transform= `translateY(-50%)`;
                            break;
                        case 3: elem.style.transform= `translate(-50%, -50%)`;
                            break;
                    }
                }
                function minSizeGrid(elem) {

                    elem.style.width = `100%`;
                    elem.style.height= `50vh`;
                    elem.style.transform= ``;
                    setTimeout(() => {elem.style.zIndex = "auto";elem.style.position = 'relative'; }, 1000)
                }
                setTimeout(callbackTimeout, animTime);

            })

    }
    window.addEventListener("load", () =>{
        foo();
        setInterval(foo, 3600000);
    });





</script>
</body>
</html>





