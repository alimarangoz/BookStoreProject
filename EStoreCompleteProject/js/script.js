/*let products = [
    {
        name: "Harry Potter Series",
        media: "Yapi Kredi Yayinlari",
        price: 74.00,
        inCart:0},
    {
        name: "The Hungry Games",
        media: "DEX",
        price: 42.00,
        inCart:0},

]

let cartItems = document.querySelectorAll(".add-cart")


for(let i = 0; i < cartItems.length; i++){
    cartItems[i].addEventListener('click',() =>{
        cartNumbers(products[i]);
        totalCost(products[i])
    })
}

function loadingCartNumber(){
    let productNumbers = localStorage.getItem('cartNumbers');

    if(productNumbers == null){
        document.querySelector(".cart span").textContent = productNumbers;
    }
}

function cartNumbers(product){

    let numberOfProduct = localStorage.getItem('cartNumbers');
    numberOfProduct = parseInt(numberOfProduct);
    if(numberOfProduct){
        localStorage.setItem('cartNumbers', numberOfProduct + 1);
        document.querySelector(".nav-link span").textContent = numberOfProduct + 1;
    }else{
        localStorage.setItem('cartNumbers', 1);
        document.querySelector(".nav-link span").textContent = 1;
    }

    setItems(product);

}
//Setting items with its quantity
function setItems(product){
    let cartItems = localStorage.getItem("productsInCart");
    cartItems = JSON.parse(cartItems);
    if(cartItems != null){
        if(cartItems[product.name] == undefined){
            cartItems = {
                ...cartItems,
                [product.name]:product
            }
        }
        cartItems[product.name].inCart += 1;
    }else{
        product.inCart = 1;
        cartItems = {
            [product.name]:product
        }
    }

    localStorage.setItem("productsInCart",JSON.stringify(cartItems)) //!**Set items using local storage and stringify it with object item
}

function totalCost(product){                                //displaying total cost
    let cartCost = localStorage.getItem("totalCost");

    localStorage.setItem("totalCost",product.price);
    if(cartCost != null){
        cartCost = parseInt(cartCost);
        localStorage.setItem("totalCost",cartCost + product.price);
    }else{
        localStorage.setItem("totalCost",product.price);
    }
}

function printCart(){                                       //display in cart what you add using local storage
    let cartItems = localStorage.getItem("productsInCart");
    cartItems = JSON.parse(cartItems); //convert the cartItems to object.
    let productContainer = document.querySelector(".products");
    let cartCost = localStorage.getItem("totalCost");
    if(cartItems && productContainer){
        productContainer.innerHTML = "";
        Object.values(cartItems).map(item => {
            productContainer.innerHTML += `
            <div class = "product">
                <a type="button"><i class="fa fa-times" aria-hidden="true"></i></a>
               <img src = "images/${item.name}.jpg" height="200px">
                <span class="item-name">${item.name}</span>
            </div>
            <div class="product-price">
                Price: $${item.price}
            </div>
            <div class="quantity">
                Quantity: ${item.inCart}
            </div>
            <div class="total">
                Total: $${(item.inCart * item.price)}            
            </div>
            `
        });

        productContainer.innerHTML += `
            <div class "totalCartPrice">
                <h4 class="basketTotalTitle">Cart Total</h4>
                <h4 class="basketTotal">$${cartCost}</h4>
            </div>
        
        `;
    }
}
//load and print in every refresh
loadingCartNumber();
printCart();*/

//Purchase phase of shopping
$(".form-row").hide();
$(".form-select").hide();
$(".btn-purchase").click(function (){
    $(".form-select").show();
});

$( ".form-select" ).change(function() {
    var val = $(".form-select").val();
    if(val=="1"){
        $(".form-row").show();
    } else if(val =="2") {
        $(".form-row").show();
    }else{
        $(".form-row").hide();
    }
});

//Adding a new item

/*function addItem (event){
    event.preventDefault();
    let bookName = document.getElementById("bname").value;
    let mediaName = document.getElementById("mname").value;
    let price = document.getElementById("price").value;
    let getImg = document.getElementById("getImg").files[0].name;

    document.getElementById("content").innerHTML += `
        <div class="item">
            <img class="images" src= "images/${(getImg)}"  height="200px" />
            <h3 class="bookNames">${(bookName)}</h3> 
            <p class="mediaType" style="font-size: 14px">${(mediaName)}</p>
            <span class="price">$${(price)}</span>
            <button class="btn btn-light cartButton"><i class="fa fa-shopping-cart" aria-hidden="true"></i><a class="add-cart" href="#">ADD TO CART</a></button>
        </div> `;


}

$(".addItemB").click(addItem);*/










