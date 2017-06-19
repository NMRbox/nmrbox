
import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'home-page',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {
  title = "Home Page";

  config: Object = {
            pagination: '.swiper-pagination',
            paginationClickable: true,
            slidesPerView: 'auto',
            centeredSlides: true,
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            spaceBetween: 0,
            speed: 1500,
					  autoplay: 4000,
			      autoplayDisableOnInteraction: false,
            loop: true
        };
  constructor(
    private router: Router
  ) { }
  
  ngOnInit(): void {
    this.router.navigate(['/app']);
  }

}