
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

  // Navigation
  gotoSection(section: string, subSection: string): void {
    this.router.navigate(['/'+section, subSection]);
  }

  gotoSoftwareFilter(filterName: string): void {
    if(!filterName || filterName == "all"){
      this.router.navigate(['/software']);
    } else {
      this.router.navigate(['/software', filterName]);
    }
  }

  //gotoCommunityPage(contentType: string, contentId: string): void {
  gotoCommunityPage(contentType: string): void {
    if(!contentType || contentType == "all"){
      this.router.navigate(['/community']);
    } else {
      //this.router.navigate(['/c', contentType, contentId]);
      this.router.navigate(['/c', contentType]);
    }
  }
}