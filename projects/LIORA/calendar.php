<?php
session_start();
include 'header.php';
?>
<!--=============== HEADER ===============-->
     

    <!--=============== MAIN ===============-->
    <main class="main">

            <div class="cart__header cart__header-box container">
  <h2 class="section__title">
<span>My</span> Flower Moments 🌷  </h2>
<p class="delivery__order">Never forget a special moment again 💖</p>
</div>


      <!--=============== CALENDAR INTRO ===============-->
      <section class="calendar section--lg container">


        <!--=============== EVENT FORM ===============-->
        <div class="calendar__event-box">
          <h3 class="calendar__box-title">🌸 Add a Special Moment</h3>

          <form id="event-form" class="calendar__form grid">
            <input type="text" id="event-name" class="form__input" placeholder="Event name" required />
            <input type="date" id="event-date" class="form__input" required />
            <select id="event-type" class="form__input" required>
              <option value="">Occasion type</option>
              <option>Birthday</option>
              <option>Anniversary</option>
              <option>Graduation</option>
              <option>Wedding</option>
              <option>Mother's Day</option>
              <option>Valentine's Day</option>
              <option>Other</option>
            </select>
            <button type="submit" class="btn">Save Date</button>
          </form>
        </div>

        <!--=============== MONTHS ===============-->
        <div class="calendar__months grid">
          <div class="calendar__card" data-month="January">
            <h3 class="calendar__month-title">January</h3>
            <div class="calendar__mini">
              <span>01</span><span>05</span><span>12</span><span>18</span><span>25</span>
            </div>
          </div>

          <div class="calendar__card" data-month="February">
            <h3 class="calendar__month-title">February</h3>
            <div class="calendar__mini">
              <span>03</span><span>09</span><span>14</span><span>21</span><span>27</span>
            </div>
          </div>

          <div class="calendar__card" data-month="March">
            <h3 class="calendar__month-title">March</h3>
            <div class="calendar__mini">
              <span>02</span><span>08</span><span>15</span><span>22</span><span>29</span>
            </div>
          </div>

          <div class="calendar__card" data-month="April">
            <h3 class="calendar__month-title">April</h3>
            <div class="calendar__mini">
              <span>04</span><span>10</span><span>16</span><span>20</span><span>28</span>
            </div>
          </div>

          <div class="calendar__card" data-month="May">
            <h3 class="calendar__month-title">May</h3>
            <div class="calendar__mini">
              <span>01</span><span>06</span><span>11</span><span>19</span><span>26</span>
            </div>
          </div>

          <div class="calendar__card" data-month="June">
            <h3 class="calendar__month-title">June</h3>
            <div class="calendar__mini">
              <span>03</span><span>08</span><span>14</span><span>21</span><span>30</span>
            </div>
          </div>

          <div class="calendar__card" data-month="July">
            <h3 class="calendar__month-title">July</h3>
            <div class="calendar__mini">
              <span>02</span><span>07</span><span>13</span><span>20</span><span>27</span>
            </div>
          </div>

          <div class="calendar__card" data-month="August">
            <h3 class="calendar__month-title">August</h3>
            <div class="calendar__mini">
              <span>01</span><span>09</span><span>15</span><span>22</span><span>31</span>
            </div>
          </div>

          <div class="calendar__card" data-month="September">
            <h3 class="calendar__month-title">September</h3>
            <div class="calendar__mini">
              <span>04</span><span>10</span><span>16</span><span>23</span><span>29</span>
            </div>
          </div>

          <div class="calendar__card" data-month="October">
            <h3 class="calendar__month-title">October</h3>
            <div class="calendar__mini">
              <span>05</span><span>11</span><span>18</span><span>24</span><span>30</span>
            </div>
          </div>

          <div class="calendar__card" data-month="November">
            <h3 class="calendar__month-title">November</h3>
            <div class="calendar__mini">
              <span>02</span><span>08</span><span>14</span><span>21</span><span>28</span>
            </div>
          </div>

          <div class="calendar__card" data-month="December">
            <h3 class="calendar__month-title">December</h3>
            <div class="calendar__mini">
              <span>03</span><span>09</span><span>17</span><span>24</span><span>31</span>
            </div>
          </div>
        </div>


        <div id="mini-calendar" class="mini-calendar">
          <div class="mini-box">
            <h3 id="mini-title">Month</h3>

            <div class="mini-week">
              <span>Su</span><span>Mo</span><span>Tu</span>
              <span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
            </div>

            <div id="mini-days" class="mini-days"></div>

            <div class="mini-buttons">
              <button id="close-mini" class="mini-btn mini-btn--close">Close</button>
              <button id="ok-mini" class="mini-btn mini-btn--ok">OK ✨</button>
            </div>
          </div>
        </div>

        <!--=============== SELECTED DATES HISTORY ===============-->
        <div class="calendar__history-box">
          <h3 class="calendar__box-title">📅 My Selected Flower Moments</h3>
          <div id="calendar-history-list" class="calendar__history-list">
            <p class="calendar__history-empty">No special moments selected yet 🌸 Click on any day to add one!</p>
          </div>
          <button id="clear-history" class="calendar__clear-btn">Clear All History</button>
        </div>

      </section>


    </main><script src="assets/js/calendar.js"></script>
         <!--=============== search ===============--><?php include 'footer.php'; ?>


