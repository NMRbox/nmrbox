import {Component, OnInit} from '@angular/core';
import {environment} from '../../environments/environment';
import {EventModel} from '../community/event.model';
import {CommunityService} from '../community/community.service';
import {AuthenticationService} from '../authentication/authentication.service';
import {SoftwareService} from '../software/software.service';
import {ResponsiveService} from '../responsive.service';
import {StaticPageService} from '../static/static-page.service';

class Banner {
  imageURL: string;
  linkURL: string;
  altValue: string;

  constructor(imageUrl, linkURL, altValue) {
    this.imageURL = imageUrl;
    this.linkURL = linkURL;
    this.altValue = altValue;
  }
}

function choose(choices) {
  const choice: Banner = choices.splice(Math.floor(Math.random() * choices.length), 1)[0];
  // Alternate between bear and t-rex for Jon
  if (choice.imageURL.indexOf('dino') > -1) {
    if (Math.random() >= 0.5) {
      choice.imageURL = choice.imageURL.replace('dino', 'bear');
    }
  }
  return choice;
}

@Component({
  selector: 'app-home-page',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  appURL: string;
  announcements: string;
  upcomingEvents: EventModel[];
  softwareTypeFrequency: Array<Array<string>>;
  bannerList: Array<Banner>;
  softwareBanners: Array<Banner> =
    [new Banner('https://api.nmrbox.org/files/developer-banner-gerard.png', '/s/spectrum-translator', 'Gerard Weatherby'),
     new Banner('https://api.nmrbox.org/files/developer-banner-alexandre.png', 'http://www.bonvinlab.org/software/haddock2.2/',
       'Alexandre  Bonvin'),
     new Banner('https://api.nmrbox.org/files/developer-banner-frank.png', '/s/nmrpipe', 'Frank Delaglio'),
     new Banner('https://api.nmrbox.org/files/developer-banner-jon-dino.jpg', '/s/bmrb-cs-rosetta', 'Jon Wedell')];

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
              public responsiveService: ResponsiveService,
              public staticPageService: StaticPageService) {
    this.upcomingEvents = [];
    this.softwareService.softwareTypeFrequency.subscribe(softwareTypeFrequency => {
      this.softwareTypeFrequency = softwareTypeFrequency;
    });

    this.bannerList = [new Banner('https://api.nmrbox.org/files/event-banner-60th-enc.png', 'https://www.enc-conference.org/',
      '60th ENC')];
    this.bannerList.push(choose(this.softwareBanners));
    this.bannerList.push(choose(this.softwareBanners));
    this.announcements = null;
  }

  ngOnInit(): void {
    this.appURL = environment.appUrl;

    this.communityService.upcomingEvents.subscribe(upcomingEvents => {
      this.upcomingEvents = upcomingEvents;
    });

    this.staticPageService.getPageContent('announcements').then(response => {
      // Make sure that there is an active announcement. (There are always some HTML tags.)
      if (response['content'].length > 15) {
        this.announcements = response['content'];
      }
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
