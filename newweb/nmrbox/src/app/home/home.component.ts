import {Component, OnInit} from '@angular/core';
import {environment} from '../../environments/environment';
import {EventModel} from '../community/event.model';
import {CommunityService} from '../community/community.service';
import {AuthenticationService} from '../authentication/authentication.service';
import {SoftwareService} from '../software/software.service';
import {ResponsiveService} from '../responsive.service';

@Component({
  selector: 'app-home-page',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  appURL: string;
  upcomingEvents: EventModel[];
  softwareTypeFrequency: Array<Array<string>>;

  public notifications: any = {message: '', type: ''};

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

  constructor(public communityService: CommunityService,
              public authService: AuthenticationService,
              public softwareService: SoftwareService,
              public responsiveService: ResponsiveService) {
    this.upcomingEvents = [];
    this.softwareService.softwareTypeFrequency.subscribe(softwareTypeFrequency => {
      this.softwareTypeFrequency = softwareTypeFrequency;
    });
  }

  ngOnInit(): void {
    this.appURL = environment.appUrl;

    this.communityService.upcomingEvents.subscribe(upcomingEvents => {
      this.upcomingEvents = upcomingEvents;
    });
  }

  onWorkshopRegister(workshopName) {

    this.authService.workshopRegister(workshopName)
      .subscribe(
        response => this.notifications = response,
        error => this.notifications = error,
        () => this.communityService.updateEvents()
      );
  }
}
