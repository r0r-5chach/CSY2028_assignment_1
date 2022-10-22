<?php
$pageTitle = 'iBuy - Product Listing'; 
//TODO: have page populate information based on listing in the database
$pageContent = '<h1>Product Page</h1>
<article class="product">

        <img src="product.png" alt="product name">
        <section class="details">
            <h2>Product name</h2>
            <h3>Product category</h3>
            <p>Auction created by <a href="#">User.Name</a></p>
            <p class="price">Current bid: £123.45</p>
            <time>Time left: 8 hours 3 minutes</time>
            <form action="#" class="bid">
                <input type="text" name="bid" placeholder="Enter bid amount" />
                <input type="submit" value="Place bid" />
            </form>
        </section>
        <section class="description">
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sodales ornare purus, non laoreet dolor sagittis id. Vestibulum lobortis laoreet nibh, eu luctus purus volutpat sit amet. Proin nec iaculis nulla. Vivamus nec tempus quam, sed dapibus massa. Etiam metus nunc, cursus vitae ex nec, scelerisque dapibus eros. Donec ac diam a ipsum accumsan aliquet non quis orci. Etiam in sapien non erat dapibus rhoncus porta at lorem. Suspendisse est urna, egestas ut purus quis, facilisis porta tellus. Pellentesque luctus dolor ut quam luctus, nec porttitor risus dictum. Aliquam sed arcu vehicula, tempor velit consectetur, feugiat mauris. Sed non pellentesque quam. Integer in tempus enim.</p>


        </section>

        <section class="reviews">
            <h2>Reviews of User.Name </h2>
            <ul>
                <li><strong>Ali said </strong> great ibuyer! Product as advertised and delivery was quick <em>29/09/2019</em></li>
                <li><strong>Dave said </strong> disappointing, product was slightly damaged and arrived slowly.<em>22/07/2019</em></li>
                <li><strong>Susan said </strong> great value but the delivery was slow <em>22/07/2019</em></li>

            </ul>

            <form>
                <label>Add your review</label> <textarea name="reviewtext"></textarea>

                <input type="submit" name="submit" value="Add Review" />
            </form>
        </section>
        </article>';
require '../layout.php'
?>