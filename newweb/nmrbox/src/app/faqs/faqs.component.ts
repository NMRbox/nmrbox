import { Component, OnInit, AfterViewInit } from '@angular/core';
import {FormGroup, FormControl, FormBuilder, Validators, NgForm} from '@angular/forms';
import { Router } from '@angular/router';
import { ActivatedRoute, Params } from '@angular/router';
import { Observable} from 'rxjs/Observable';

/* import model files */
import { FaqsModel} from './faqs.model';

/* import service files */
import { FaqsService } from './faqs.service';

@Component({
  selector: 'app-faqs',
  templateUrl: './faqs.component.html',
  styleUrls: ['./faqs.component.css']
})
export class FaqsComponent implements OnInit {
    faqs: FaqsModel;
    allFaqs: FaqsModel[];
    showHide: boolean;
    public notifications: any = {message: '', type: ''};

    constructor(
      private faqService: FaqsService,
      private router: Router,
      private route: ActivatedRoute,
    ) {
      this.showHide = false;
    }

    ngOnInit(): void {
      /* get all FAQs*/
      this.getAllFaqs();
    }

    getAllFaqs(): void {
        this.faqService.getAllFaqs().then(allFaqs => this.faqs = allFaqs);
    }

}
