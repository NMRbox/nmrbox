import {Component, OnInit} from '@angular/core';
import {environment} from '../../environments/environment';
import {EventModel} from '../community/event.model';
import {CommunityService} from '../community/community.service';

@Component({
  selector: 'app-home-page',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  appURL: string;
  upcomingEvents: EventModel[];

  config: Object = {
    pagination: '.swiper-pagination',
    paginationClickable: true,
    slidesPerView: 'auto',
    centeredSlides: true,
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
    spaceBetween: 0,
    speed: 1500,
    autoplay: 6000,
    autoplayDisableOnInteraction: false,
    loop: true
  };

  constructor(public communityService: CommunityService) {
    this.upcomingEvents = [];
  }

  ngOnInit(): void {
    this.appURL = environment.appUrl;

    this.communityService.getAllEvents().then(events => {
      this.upcomingEvents = events[0] as EventModel[];
    });
  }

}
