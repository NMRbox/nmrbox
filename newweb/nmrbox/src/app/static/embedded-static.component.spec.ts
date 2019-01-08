import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EmbeddedStaticComponent } from './embedded-static.component';

describe('EmbeddedStaticComponent', () => {
  let component: EmbeddedStaticComponent;
  let fixture: ComponentFixture<EmbeddedStaticComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EmbeddedStaticComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EmbeddedStaticComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
