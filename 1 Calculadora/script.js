const display = document.querySelector("#display"); //selecciona solo uno: # --> id
const buttons = document.querySelectorAll("button"); // selecciona un grupo de elementos . --> class
buttons.forEach((item)=>{
    item.onclick =()=>{// el parentecis es para pasarle algun argumento al hacer click
        if (item.id == "clear"){
            display.innerText = "";
        }else if(item.id == "backspace"){
            let  string = display.innerText.toString();
            display.innerText = string.substr(0, string.length - 1); //nos extrae el ultimo caracteres --> string.length() - 1: numero de carac. menos 1
        }else if(display.innerText != "" && item.id == "equal"){
            display.innerText = eval(display.innerText); // eval: de una cadena de caracteres pasa a opreciones aricmeticas
        }else if(display.innerText == "" && item.id == "equal"){
            display.innerText="Null";
            setTimeout(()=>(display.innerText=""), 2000) // efecuta una funcion dentro un determinado texto (ms)
        }else{
            display.innerText += item.id; //88 + 55 + 2 /
        }
    }
});

const themeToggleBtn = document.querySelector(".theme-toggler");
const calculator = document.querySelector(".calculator");
let isDark = true;
themeToggleBtn.onclick=()=>{
    calculator.classList.toggle("dark");
    themeToggleBtn.classList.toggle("active");
    isDark = !isDark;
}