let body = document.body;

function disableDescription(){
	//let desc = document.getElementsByClassName("description_tab");
	//console.info(desc);
	jQuery(".description_tab").remove();
	jQuery(".woocommerce-Tabs-panel--description").remove();
	jQuery(".additional_information_tab").addClass('active');
	jQuery(".site-main").css('margin-top','50px');
}

function PPOM_form_display(){
	let grpform = document.getElementsByClassName("form-group");
    let first = true; // first ele
    let req = document.getElementsByClassName("show_required");
    
    jQuery(".show_required").css('display','none');

    for(let i = 0; i < grpform.length; i++){

        if(grpform[i].childElementCount > 5){
            continue;
        }
        for(let j = 0; j < grpform[i].children.length; j++){  
            if(grpform[i].children[j].className.match("form-control-label")){
                grpform[i].children[j].style.margin = "auto";
            }
            if(grpform[i].children[j].className.match("form-check")){
               
            }
        }
        grpform[i].style.display = "flex";
        grpform[i].style.flexdirection = "row";  
        if(first){
            grpform[i].style.backgroundColor = "#efebe9";
            first = false
        }else{
            first = true;
        }
    }
}
function moveRo(){
    let details = document.getElementsByClassName("woocommerce-product-details__short-description");

    for(let i = 0; i < details.length; i++){
        details[i].remove;
        
    }
    jQuery(".woocommerce-product-details__short-description").detach().insertBefore(".product_meta");
}


function setFire(){
    console.log("fire");
}


function catDisplay(){
    let https = window.location.href;
    let code = https.split("?")[1];
    //console.log(code);
    if(document.getElementsByClassName("mm-item-has-sub")){
        
        var catList = document.getElementsByClassName("mm-item-has-sub");

        let str = jQuery(".mm-item-has-sub ul li a").prevObject;
        let strI= jQuery(".mm-item-has-sub");
      //  console.log(strI.Length);

              
        for(let i = 0; i < catList.length; i++){
            if(strI[i].URL.includes(code)){
        //        console.log("XX");
          //      console.log(strI[i]);
            }
        }



    }
}
if(body.className.match("archive ")){
    catDisplay();
}

if(body.className.match("term-poliai-ir-irangos-nuoma")){
	let link = "#";
	let pic = "https://78.60.66.246/wp-content/uploads/2021/06/DSC03597-300x225.jpg";
	let name = "Placeholder";
	
	let cat = document.getElementsByClassName("product-category");
	let prod = document.getElementsByClassName("product_item");
	jQuery("#la_shop_products .row").hide();
	for(let i = 0; i < prod.length;i++){
		if(!prod[i].classList.contains("product_cat-poliai")){
			link = prod[i].children[0].children[0].children[0].children[0].href; 
			pic = prod[i].children[0].children[0].children[0].children[0].children[0].src;
			name = prod[i].children[0].children[1].children[0].children[0].children[0].text;
			let productV = '<li class="product-category product first grid-item"><a href="'+link+'"><div class="cat-img"><img src="'+ pic +'" alt="Poliai" width="300" height="225"><span class="item--overlay"></span></div><div class="cat-information"><h2 class="woocommerce-loop-category__title">'+name+'<mark class="count">(4)</mark></h2></div></a></li>';
			jQuery(".catalog-grid-1").append(productV);
		}

	}	
	jQuery(".product_item--action").hide();
	jQuery(".wrap-addto").hide();
		
		jQuery(document).ready(function(){
    jQuery('a').each(function(){
        this.href = this.href.replace('produktas/irangos-nuoma/', 'irangos-nuoma/');
		this.href = this.href.replace('product-category/terraces', 'terraces');
		this.href = this.href.replace('produkto-kategorija/terasos-fr', 'terraces');//fr
		this.href = this.href.replace('produkto-kategorija/terasos-de', 'terraces');//de
		
		this.href = this.href.replace('produktas/sraigtiniu_poliu_montavimas/', 'sraigtiniu-poliu-montavimas/');
		this.href = this.href.replace('product-category/terraces', 'terraces');
		this.href = this.href.replace('produkto-kategorija/terasos-fr', 'terraces');//fr
		this.href = this.href.replace('produkto-kategorija/terasos-de', 'terraces');//de
		
    });
});
}
if(body.className.match("term-statybine-mediena")){
	let link = "#";
	let pic = "https://78.60.66.246/wp-content/uploads/2021/06/DSC03597-300x225.jpg";
	let name = "Placeholder";
	
	let cat = document.getElementsByClassName("product-category");
	let prod = document.getElementsByClassName("product_item");
	jQuery("#la_shop_products .row").hide();
	for(let i = 0; i < prod.length;i++){
		if(!prod[i].classList.contains("product_cat-poliai")){
			link = prod[i].children[0].children[0].children[0].children[0].href; 
			pic = prod[i].children[0].children[0].children[0].children[0].children[0].src;
			name = prod[i].children[0].children[1].children[0].children[0].children[0].text;
			let productV = '<li class="product-category product first grid-item"><a href="'+link+'"><div class="cat-img"><img src="'+ pic +'" alt="Poliai" width="300" height="225"><span class="item--overlay"></span></div><div class="cat-information"><h2 class="woocommerce-loop-category__title">'+name+'<mark class="count">(4)</mark></h2></div></a></li>';
			jQuery(".catalog-grid-1").append(productV);
		}

	}	
	jQuery(".product_item--action").hide();
	jQuery(".wrap-addto").hide();
		
		jQuery(document).ready(function(){
    jQuery('a').each(function(){
        this.href = this.href.replace('produktas/neobliuota-mediena', 'neobliuota_mediena');
		this.href = this.href.replace('product-category/terraces', 'terraces');
		this.href = this.href.replace('produkto-kategorija/terasos-fr', 'terraces');//fr
		this.href = this.href.replace('produkto-kategorija/terasos-de', 'terraces');//de
		
		this.href = this.href.replace('produktas/obliuota-mediena', 'obliuota_mediena');
		this.href = this.href.replace('product-category/terraces', 'terraces');
		this.href = this.href.replace('produkto-kategorija/terasos-fr', 'terraces');//fr
		this.href = this.href.replace('produkto-kategorija/terasos-de', 'terraces');//de
		
    });
});
	
}


if(body.className.match("single-product")){
PPOM_form_display();
moveRo();
disableDescription();
}

if(body.className.match("page-template-default") || body.className.match("home")){
	jQuery(document).ready(function(){
    jQuery('a').each(function(){
        this.href = this.href.replace('produkto-kategorija/terasos/', 'terasos/');
		this.href = this.href.replace('product-category/terraces', 'terraces');
		this.href = this.href.replace('produkto-kategorija/terasos-fr', 'terraces');//fr
		this.href = this.href.replace('produkto-kategorija/terasos-de', 'terraces');//de
    });
});
}
if(body.className.match("home")){
	jQuery(".site-content").css('margin-top','50px');
}

// Checkout page
function interactiveCheckout(){
	
	jQuery("#billing_imones_kodas_field").css('display', 'none');
	jQuery("#billing_company_field").css('display', 'none');
	jQuery("#billing_pvm_kodas_field").css('display', 'none');
	jQuery("#is_country_authority_field").css('display', 'none');
	jQuery("#billing_imones_adresas_field").css('display', 'none');
	
	jQuery(".woocommerce-billing-fields__field-wrapper").css('display','flex');
	jQuery(".woocommerce-billing-fields__field-wrapper").css('flex-direction','column');
}
function is_company(a){
	if(a == true){
		jQuery("#billing_imones_kodas_field").show("slow");
		jQuery("#billing_company_field").show("slow");
		jQuery("#billing_pvm_kodas_field").show("slow");
		jQuery("#is_country_authority_field").show("slow");
		jQuery("#billing_imones_adresas_field").show("slow");
	}else{
		jQuery("#billing_imones_kodas_field").hide("specialEasing");
		jQuery("#billing_company_field").hide("specialEasing");
		jQuery("#billing_pvm_kodas_field").hide("specialEasing");
		jQuery("#is_country_authority_field").hide("specialEasing");
		jQuery("#billing_imones_adresas_field").hide("specialEasing");
	}
}

if(body.className.match("woocommerce-checkout")){
	interactiveCheckout();
	
	jQuery(document).ready(function(){
		jQuery('input[id^="is_company"]').click(function(){
			if(jQuery(this).prop("checked") == true){
				is_company(true);
			}else if(jQuery(this).prop("checked") == false){
				is_company(false);
			}
		});
	});
}


// footer
jQuery(document).ready(function(){
	jQuery(".footer-top").css('background-image','linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(//78.60.66.246/wp-content/uploads/2021/06/03447be73c5b73a3f66b411eaf05ff67.jpg)');
	
});