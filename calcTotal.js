"use strict";


        window.onload = function()
                        {
                            var myButton = document.getElementById("calcTotal");

                            myButton.onclick = calcTotal;
                        };

function calcTotal()
{
    var priceVal = document.getElementById("price");
    var quantVal = document.getElementById("quant");

    var newPrice = parseFloat(priceVal.innerHTML);
    var newQuant = parseFloat(quantVal.innerHTML);

    var product = newPrice * newQuant;
    var tax = newPrice * .0775;
    var fin = product + tax;
    tax = tax.toFixed(2);
    fin = fin.toFixed(2);
    product = product.toFixed(2);
    

    var resultSub = document.getElementById("sub");
    var resultTax = document.getElementById("tax");
    var resultTotal = document.getElementById("total");

    resultSub.innerHTML = product;
    resultTax.innerHTML = tax;
    resultTotal.innerHTML = fin;
}
