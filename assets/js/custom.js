(function(){

   docReady(async function() {
      
      // Slider Price range Value on page ready
      renderRangeValue();
      
      let form = document.querySelector('.book-shop-main .search-filters form');

      // Get all books on page ready
      let data = urlencodeFormData(new FormData(form))+'&action=getAllBooks&nonce='+bookshop.nonce;
      await renderBooks(data);

      // Get all Publishers on page ready
      await renderPublishers();

      // Get all Authors on page ready
      await renderAuthors();

      // Get books based on search filter
      form.addEventListener('submit', searchData);

      // Change range price on input change 
      let slider = document.querySelector(".book-shop-main .search-filters #price");
      slider.addEventListener('input', renderRangeValue);

      // Get Books for current page 
      document.body.addEventListener('click', paginateData);

   });

   async function paginateData(event){
      if(event.target.classList.contains("paginatelink")){
         event.preventDefault();
         let page = event.target.getAttribute("data-page");
         let form = document.querySelector('.book-shop-main .search-filters form');
         let data = urlencodeFormData(new FormData(form))+'&paged='+page+'&action=getAllBooks&nonce='+bookshop.nonce;
         await renderBooks(data);
      }
   }

   async function searchData(event) {
     event.preventDefault();
     let form  = document.querySelector('.book-shop-main .search-filters form');
     let data  = urlencodeFormData(new FormData(form))+'&action=getAllBooks&nonce='+bookshop.nonce;
     await renderBooks(data);
   }

   async function renderBooks(formdata){
      // Get all books on page ready
      let data   = formdata;
      let books  = await getAllBooks(data);

      if(books.length){

         let total = books[books.length - 1].total;
         let page  = books[books.length - 1].page;
         renderPagination(total, parseInt(page));
         books.pop();
      }
      else{
         renderPagination(0, 0);
      }
 
      renderData(books);
   }

   function renderPagination(total,page){

      let wrapper = document.querySelector(".book-shop-main .book-data .pagination");
      
      if(total && page){
         let limit = 10;
         let pages =  Math.ceil(total/limit); 
         let html  = "<ul>";

         for (let i = 1; i <= pages; i++) {
           let isactive = (i === page) ? 'active' : ''; 
           html += "<li class='"+isactive+"' ><a class='paginatelink' href='#' data-page='"+i+"'>"+i+"</a></li>";
         }

         html  += "</ul>";
         wrapper.innerHTML = html;
      }
      else{
         wrapper.innerHTML = '';
      }
   }

   async function renderPublishers(){

      // Get all Publishers on page ready
      let data  = {'action' : 'getAllPublishers',
                   'nonce'  : bookshop.nonce,
      };

      data           = urlEncodeData(data);
      let publishers = await getAllPublishers(data);
      renderDropdownData(publishers,'publisher');
   }

   async function renderAuthors(){

      // Get all Authors on page ready
      let data  = {'action' : 'getAllAuthors',
                   'nonce'  : bookshop.nonce,
      };

      data        = urlEncodeData(data);
      let authors = await getAllAuthors(data);
      renderDropdownData(authors , 'author');
   }


   async function getAllBooks(data){
      let res  = await getData("GET",data);
      let output = '';

      if(res.status){
         output = res.output;

         if(res.total){
            output.push({'total' : res.total , 'page' : res.paged});
         }
      }
      else{
         output = [];
      }
      return output;
   }

   async function getAllPublishers(data){
      let res  = await getData("GET",data);
      return (res.status) ? res.output : [];
   }

   async function getAllAuthors(data){
      let res  = await getData("GET",data);
      return (res.status) ? res.output : [];
   }

   function renderRangeValue(){
      let slider = document.querySelector(".book-shop-main .search-filters #price");
      let output = document.querySelector(".book-shop-main .search-filters #priceval");
      output.innerHTML = slider.value;
   }

   function renderDropdownData(data , elem){
      
      let html = `<option value="">Select Option</option>`;
      for(let i = 0; i < data.length; i++){

         let id   = data[i].id;
         let name = data[i].name;

         html += `<option value="${id}">${name}</option>`; 
      }
      let element = document.querySelector('.book-shop-main .search-filters #'+elem);
      element.innerHTML = '';
      element.insertAdjacentHTML('beforeend', html);
   }


   function renderData(data){

      let html = '';
      for(let i = 0; i < data.length; i++){

         let srno     = data[i].id;
         let authr    = data[i].author;
         let publishr = data[i].publisher;
         let price    = (data[i].price)   ? data[i].price      : 'n/a';
         let rating   = (data[i].rating)  ?  (parseInt(data[i].rating) / 5) * 100 : 0;
         authr        = (authr.length)    ? authr.join(",")    : 'n/a';
         publishr     = (publishr.length) ? publishr.join(",") : 'n/a';

         html += `<tr>
                     <td>${srno}</td>
                     <td><a href="${data[i].booklink}" target="_blank">${data[i].name}</a></td>
                     <td>${price}</td>
                     <td>${authr}</td>
                     <td>${publishr}</td>
                     <td>
                        <div class="ratings">
                          <div class="empty-stars"></div>
                          <div class="full-stars" style="width:${rating}%"></div>
                        </div>
                     </td>
                  </tr>`; 

      }

      let element = document.querySelector('.book-shop-main .book-data table tbody');
      element.innerHTML = '';
      element.insertAdjacentHTML('beforeend', html);
   }


   function docReady(fn) {
       // see if DOM is already available
       if (document.readyState === "complete" || document.readyState === "interactive") {
           // call on next available tick
           setTimeout(fn, 1);
       } else {
           document.addEventListener("DOMContentLoaded", fn);
       }
   } 

   function urlEncodeData(params){
      var queryString = Object.keys(params).map(key => key + '=' + params[key]).join('&');
      return queryString;
   }

   function urlencodeFormData(fd){
      var params = new URLSearchParams();
      for(var pair of fd.entries()){
           typeof pair[1]=='string' && params.append(pair[0], pair[1]);
      }
      return params.toString();
   }


   async function getData(method,data){
       
      let url      = bookshop.ajax_url;
      let options  = {method   : method,
                      headers  : {'Content-Type': 'application/x-www-form-urlencoded'},
      };

      if(method == "POST"){
         options.body = data;
      }

      if(method == "GET"){
         url += `?${data}`;
      }

      let response = await fetch(url,options);
      response     = await response.json();
      return response;
   }

})();