<div class="book-shop-main">
    <div class="search-filters"> 
        <form method="post" id="book-shop-form">
            <div class="form-field">
                <label for="bookname">Book Name</label>
                <input id="bookname" type="text" name="bookname">
            </div>
             <div class="form-field">
                <label for="author">Author</label>
                <select id="author"name="author">
                </select>
            </div>
            <div class="form-field">
                <label for="publisher">Publisher</label>
                <select id="publisher"name="publisher">
                </select>
            </div>
            <div class="form-field">
                <label for="rating">Rating</label>
                <select id="rating"name="rating">
                    <option value="">Select</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="form-field">
                <label for="price">price <span id="priceval"></span></label>
                <input id="price" type="range" name="price" min="1" max="1000">
            </div>
            <div class="form-field">
                <input type="submit" name="search" value="search">
            </div>
        </form>
    </div>
    <div class="book-data">
        <table>
            <thead>
                <th>No</th>
                <th>Book Name</th>
                <th>Price</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Rating</th>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div class="pagination">
        </div>
    </div>
</div>