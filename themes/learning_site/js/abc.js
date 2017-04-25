var select = document.createElement("select");
select.id = "au_1_sel";
select.name="au_1_sel";
select.class=class="searchw8";

var option1 = document.createElement("option");
option.value="AU";
option.selected="";
option.innerHTML= "method1";

var option2 = document.createElement("option");
option.value="FI";
option.innerHTML= "method2";

select.addChild(option1);
select.addChild(option2);
document.addChild(select);