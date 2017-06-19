import { InMemoryDbService } from 'angular-in-memory-web-api';
export class SoftwareDataService implements InMemoryDbService {
  createDb() {
    let softwareList = [
      {
        "id": 36,
        "name": "NMRPIPE",
        "short_title": "NMRPipe",
        "long_title": "NMRPIPE",
        "synopsis": "Multidimensional spectral processing and analysis of NMR data.",
        "description": "NMRPipe is an extensive software system for processing, analyzing, and exploiting NMR spectroscopic data. An NMRPipe installation also provides the applications NMRDraw, NMRWish, TALOS+, SPARTA+, DYNAMO, DC, MFR, ACME, and others.",
        "url": " https://www.ibbr.umd.edu/nmrpipe/",
        "slug": "nmrpipe",
        "nmrbox_version":"5.1",
        "software_version":"11.0.5",
        //"software_types": ['spectral','assignment','relaxation','chemical-shift','molecular-modeling','structure','rdc'],
        "software_types": ['spectral','assignment','relaxation','chemical-shift','molecular-modeling','structure','rdc','metabolmics','protein-dynamics','protein-structure','intrinsically'],
        "research_problems": ['metabolomics','protein-dynamics','protein-structure','intrinsically']
      },
      {
        "id": 43,
        "name": "RNMRTK",
        "short_title": "RNMRTK",
        "long_title": "The Rowland NMR Toolkit",
        "synopsis": "General-purpose NMR data processing package, including maximum entropy spectral reconstruction.",
        "public_release": null,
        "description": "The Rowland NMR Toolkit (RNMRTK) is a software package for processing \r\nmultidimensional NMR data and a platform for the facile implementation \r\nof novel NMR data processing methods. In addition to efficient and \r\nrobust algorithms for traditional signal processing methods such as \r\nlinear prediction extrapolation and discrete Fourier transformation, \r\nRNMRTK implements a very powerful and general algorithm for computing \r\nmaximum entropy (MaxEnt) reconstruction, which is especially useful for \r\nprocessing non-uniformly sampled NMR data. RNMRTK provides rudimentary \r\ntools for analyzing and displaying spectra, but is best used in \r\nconjunction with more powerful and general-purpose analysis software. \r\nRNMRTK interoperates with nmrPipe, nmrDraw, XEASY, Sparky, NMRview, and \r\nother NMR software packages. ",
        "url": "http://rnmrtk.uchc.edu/rnmrtk/RNMRTK.html",
        "slug": "rnmrtk",
        "nmrbox_version":"5.1",
        "software_version":"6.5",
        "software_types": ['spectral'],
        "research_problems": ['protein-dynamics','protein-structure']
      },
      {
        "id": 70,
        "name": "NMRFX",
        "short_title": "NMRFx Processor",
        "long_title": "NMRFx Processor",
        "synopsis": "An NMR data processing program utilizing Python for scripts a full Java based GUI",
        "public_release": null,
        "description": "<div>NMRFx Processor is a computer program for processing NMR datasets. It will read the raw FID file of experimental NMR data and apply a sequence of processing operations to convert the data values into a spectrum useful for subsequent analysis. NMRFx Processor is written in the Java programming language and uses Jython, the Java implementation of Python, for scripts. The two parts of the name are derived from the names of the NMRView software with which NMRFx Processor shares some low level code, and the JavaFX Graphical User Interface toolkit used for the NMRFx Processor GUI.</div><div><br></div><div>NMRFx Processor has a graphical user interface that can be used for creating, configuring and executing processing scripts. The scripts can also be executed in a non-GUI mode on the command line of Windows, Linux and Mac OS computers.</div>",
        "url": "http://www.onemoonscientific.com/nvfx-processor",
        "slug": "nmrfx",
        "nmrbox_version":"5.1",
        "software_version":"3.6",
        "software_types": ['spectral'],
        "research_problems": ['protein-structure']
      },
      {
        "id": 112,
        "name": "NMRDRAW",
        "short_title": "NMRDraw",
        "long_title": "NMRDraw",
        "synopsis": "NMRDraw is the companion graphical interface for NMRPipe and its processing tools.",
        "public_release": null,
        "description": "<p>NMRDraw is the companion graphical interface for NMRPipe and its processing tools. Features of NMRDraw include: </p><ul><li>\r\n\r\nInteractive interface for inspecting 1D-4D FIDs, interferograms, and spectra.\r\n</li><li>Real-time manipulation of one or more 1D vectors within the viewed data, including pan, zoom, vertical scaling and offset, with 1D spectral graphics overlaid on 2D contour display.\r\n</li><li>Real-time phasing of one or more vectors for any dimension, with imaginary data reconstructed automatically as needed.\r\n</li><li>Facilities for interactive processing of individual vectors, and a script editor for construction of processing schemes.\r\n</li><li>Interactive peak editing, with an interface to automated 1D-4D peak detection via NMRWish.</li></ul>",
        "url": "https://spin.niddk.nih.gov/bax/software/NMRPipe/",
        "slug": "nmrdraw",
        "nmrbox_version":"5.1",
        "software_version":"21.0.8",
        "software_types": ['spectral'],
        "research_problems": ['protein-structure']
      },
      {
        "id": 34,
        "name": "NMRFAM-SPARKY",
        "short_title": "NMRFAM-SPARKY",
        "long_title": "NMRFAM-SPARKY",
        "synopsis": "A graphical NMR assignment and integration program for proteins, nucleic acids, and other polymers.",
        "public_release": null,
        "description": "<p><font face=\"arial\"><span style=\"font-size: 16px;\"><a href=\"https://www.cgl.ucsf.edu/home/sparky\" target=\"_blank\">SPARKY</a> remains the most popular computer program for NMR operations, such as peak-picking and peak assignment, despite that fact that its originators have not released a new version since 2001 (Goddard &amp; Kneller, SPARKY 3). &nbsp;</span></font><span style=\"font-family: arial; font-size: 16px;\">NMRFAM has taken over the original Sparky from UCSF for the continuous development to implement advances in biomolecular NMR field.</span><br></p><div><span style=\"font-size: 16px; font-family: arial;\">SPARKY supports user-defined enhancements, and we have used these to develop new tools in support of our packages for automated protein assignment and structure determination.&nbsp;</span><span style=\"font-size: 16px; font-family: arial;\">The added features support</span></div><div><span style=\"font-size: 16px; font-family: arial;\"><br></span></div><p><font face=\"arial\"><span style=\"font-size: 16px;\">(1) interfacing with servers offering new technologies,<br></span></font><span style=\"font-size: 16px; font-family: arial;\">(2) tools for data visualization and verification, and<br></span><span style=\"font-size: 16px; font-family: arial;\">(3) new protocols for maximizing the efficiency of NMR data analysis.</span></p>",
        "url": "http://www.nmrfam.wisc.edu/nmrfam-sparky-distribution.htm",
        "slug": "nmrfam-sparky",
        "nmrbox_version":"5.1",
        "software_version":"12.1",
        "software_types": ['spectral'],
        "research_problems": ['protein-structure']
      },
      {
        "id": 54,
        "name": "ABACUS",
        "short_title": "ABACUS",
        "long_title": "Applied BACUS",
        "synopsis": "Combines assignment of protein NOESY spectra and structure determination.",
        "description": "ABACUS is a novel approach for protein structure \r\ndetermination that has been applied successfully for more than 20 NESG \r\ntargets. ABACUS is characterized by use of BACUS, a procedure for \r\nautomated probabilistic interpretation of NOESY spectra in terms of nunassigned proton chemical shifts based on the known information on \r\n\"connectivity\" between proton resonances. BACUS is used in both the \r\nresonance assignment and structure calculation steps. ",
        "url": "http://nmr.uhnres.utoronto.ca/arrowsmith/abacus.html",
        "slug": "abacus",
        "nmrbox_version":"5.1",
        "software_version":"10.0.5",
        "software_types": ['assignment'],
        "research_problems": ['protein-structure']
      },
      {
        "id": 3,
        "name": "PINE",
        "short_title": "ADAPT-NMR Enhancer",
        "long_title": "Assignment-directed Data collection Algorithm utilizing a Probabilistic Toolkit in NMR Enhancer",
        "synopsis": "To visualize peaks in 2D tilted planes from specific 3D NMR experiments and to correlate these with corresponding peaks in 3D space. ",
        "description": "ADAPT-NMR Enhancer is a tool for visualizing the tilted 2D plane data from ADAPT-NMR, for correlating peaks in the tilted planes with peaks in the reconstituted 3D spectrum, and for tracing the assignments of these peaks to atoms in the covalent structure of the protein. </span></span>",
        "url": "http://pine.nmrfam.wisc.edu/adapt-nmr-enhancer/index.html",
        "nmrbox_version":"5.1",
        "software_version":"3.2",
        "software_types": ['assignment'],
        "research_problems": ['protein-structure']
      } 
    ];

    let comSupportList = [
      {
        "contentType": "support",
        "id": 10,
        "name": "NMRbox: Getting Started",
        "synopsis": "A guide to help you get setup with NMRbox and find NMR software to suit your needs.",
        "description": "Support document content will go here....",
        "nmrbox_version":"5.1",
        "software_version":"11.0.5",
        "software_types": ['spectral','assignment','relaxation','chemical-shift','molecular-modeling','structure','residual-dipole-coupling'],
        "supportType": "nmrbox"
    },
      {
        "contentType": "support",
        "id": 11,
        "name": "NMRbox FAQs",
        "synopsis": "Here are some tips and answers to frequently asked questions from our NMRbox Community.",
        "description": "Support document content will go here....",
        "slug": "rnmrtk",
        "nmrbox_version":"5.1",
        "software_version":"6.5",
        "software_types": ['spectral','assignment','relaxation','chemical-shift','molecular-modeling','structure','residual-dipole-coupling'],
        "supportType": "nmrbox"
      },
      {
        "contentType": "support",
        "id": 12,
        "name": "Contact NMRbox Support",
        "synopsis": "We have a team ready to assist you with your NMRbox support needs",
        "description": "Support content will go here....",
        "slug": "rnmrtk",
        "nmrbox_version":"5.1",
        "software_version":"6.5",
        "software_types": ['spectral'],
        "supportType": "nmrbox"
      },
      {
        "contentType": "support",
        "id": 13,
        "name": "NMR Software Primer Video",
        "synopsis": "Get started using the most common NMR software",
        "description": "Support content will go here....",
        "slug": "nmrpipe",
        "nmrbox_version":"5.1",
        "software_version":"11.0.5",
        "software_types": ['spectral','assignment','relaxation','chemical-shift','molecular-modeling','structure','residual-dipole-coupling'],
        "supportType": "tutorial"
      },
      {
        "contentType": "support",
        "id": 14,
        "name": "Spectral Analysis Tutorial",
        "synopsis": "Synopsis goes here",
        "description": "Tutorial content will go here....",
        "slug": "rnmrtk",
        "nmrbox_version":"5.1",
        "software_version":"6.5",
        "software_types": ['spectral'],
        "supportType": "tutorial"
      },
      {
        "contentType": "support",
        "id": 15,
        "name": "NMRPipe User Guide",
        "synopsis": "Official user guide from the NMRPipe developers",
        "description": "Software documentation content will go here....",
        "slug": "rnmrtk",
        "nmrbox_version":"5.1",
        "software_version":"6.5",
        "software_types": ['spectral','assignment','relaxation','chemical-shift','molecular-modeling','structure','residual-dipole-coupling'],
        "supportType": "swdoc"
      },
      {
        "contentType": "support",
        "id": 15,
        "name": "Spectral Analysis Workflow Guide",
        "synopsis": "Brief synopsis",
        "description": "Article content will go here....",
        "slug": "rnmrtk",
        "nmrbox_version":"5.1",
        "software_version":"6.5",
        "software_types": ['spectral'],
        "supportType": "workflow"
      }
    ];

    let comBlogList = [
      {
        "contentType": "blog",
        "id": 10,
        "name": "Protein Dynamics",
        "synopsis": "What it really looks like.",
        "description": "NMRPipe is an extensive software system for processing, analyzing, and exploiting NMR spectroscopic data. An NMRPipe installation also provides the applications NMRDraw, NMRWish, TALOS+, SPARTA+, DYNAMO, DC, MFR, ACME, and others. NMRPipe is an extensive software system for processing, analyzing, and exploiting NMR spectroscopic data. An NMRPipe installation also provides the applications NMRDraw, NMRWish, TALOS+, SPARTA+, DYNAMO, DC, MFR, ACME, and others.",
        "url": "assets/community/blog-1.jpg",
        "author": "Adam D. Schuyler, Ph.D.",
        "authorTitle": "Assistant Professor of Molecular Biology and Biophysics",
        "authorEmail": "schuyler@uchc.edu",
        "authorPhotoUrl": "assets/community/blog-author.jpg",
        "dateCurrent": true,
        "dateCurrentStr": "true"
      },
      {
        "contentType": "blog",
        "id": 11,
        "name": "Our Research: The Medicine You Take",
        "synopsis": "Synopsis goes here",
        "description": "Article content will go here....",
        "url": "assets/community/blog-2.jpg",
        "author": "Adam D. Schuyler, Ph.D.",
        "authorTitle": "Assistant Professor of Molecular Biology and Biophysics",
        "authorEmail": "schuyler@uchc.edu",
        "authorPhotoUrl": "assets/community/blog-author.jpg",
        "dateCurrent": true
      },
      {
        "contentType": "blog",
        "id": 12,
        "name": "Experimental NMR Conference 2017",
        "synopsis": "Brief synopsis",
        "description": "Article content will go here....",
        "url": "assets/community/blog-3.jpg",
        "author": "Adam D. Schuyler, Ph.D.",
        "authorTitle": "Assistant Professor of Molecular Biology and Biophysics",
        "authorEmail": "schuyler@uchc.edu",
        "authorPhotoUrl": "assets/community/blog-author.jpg",
        "dateCurrent": true
      },
      {
        "contentType": "blog",
        "id": 13,
        "name": "Old Blog Post 1",
        "synopsis": "Synopsis goes here...",
        "description": "NMRPipe is an extensive software system for processing, analyzing, and exploiting NMR spectroscopic data. An NMRPipe installation also provides the applications NMRDraw, NMRWish, TALOS+, SPARTA+, DYNAMO, DC, MFR, ACME, and others. NMRPipe is an extensive software system for processing, analyzing, and exploiting NMR spectroscopic data. An NMRPipe installation also provides the applications NMRDraw, NMRWish, TALOS+, SPARTA+, DYNAMO, DC, MFR, ACME, and others.",
        "url": "assets/community/blog-4.jpg",
        "author": "Adam D. Schuyler, Ph.D.",
        "authorTitle": "Assistant Professor of Molecular Biology and Biophysics",
        "authorEmail": "schuyler@uchc.edu",
        "authorPhotoUrl": "assets/community/blog-author.jpg",
        "dateCurrent": false
      },
      {
        "contentType": "blog",
        "id": 14,
        "name": "Old Blog Post 2",
        "synopsis": "Synopsis goes here...",
        "description": "Article content will go here....",
        "url": "assets/community/blog-5.jpg",
        "author": "Adam D. Schuyler, Ph.D.",
        "authorTitle": "Assistant Professor of Molecular Biology and Biophysics",
        "authorEmail": "schuyler@uchc.edu",
        "authorPhotoUrl": "assets/community/blog-author.jpg",
        "dateCurrent": false
      },
      {
        "contentType": "blog",
        "id": 15,
        "name": "Old Blog Post 3",
        "synopsis": "Synopsis goes here...",
        "description": "Article content will go here....",
        "url": "assets/community/blog-6.jpg",
        "author": "Adam D. Schuyler, Ph.D.",
        "authorTitle": "Assistant Professor of Molecular Biology and Biophysics",
        "authorEmail": "schuyler@uchc.edu",
        "authorPhotoUrl": "assets/community/blog-author.jpg",
        "dateCurrent": false
      },
      {
        "contentType": "blog",
        "id": 16,
        "name": "Old Blog Post",
        "synopsis": "Synopsis goes here...",
        "description": "NMRPipe is an extensive software system for processing, analyzing, and exploiting NMR spectroscopic data. An NMRPipe installation also provides the applications NMRDraw, NMRWish, TALOS+, SPARTA+, DYNAMO, DC, MFR, ACME, and others. NMRPipe is an extensive software system for processing, analyzing, and exploiting NMR spectroscopic data. An NMRPipe installation also provides the applications NMRDraw, NMRWish, TALOS+, SPARTA+, DYNAMO, DC, MFR, ACME, and others.",
        "url": "assets/community/blog-7.jpg",
        "author": "Adam D. Schuyler, Ph.D.",
        "authorTitle": "Assistant Professor of Molecular Biology and Biophysics",
        "authorEmail": "schuyler@uchc.edu",
        "authorPhotoUrl": "assets/community/blog-author.jpg",
        "dateCurrent": false
      },
      {
        "contentType": "blog",
        "id": 17,
        "name": "Old Blog Post",
        "synopsis": "Synopsis goes here...",
        "description": "Article content will go here....",
        "url": "assets/community/blog-8.jpg",
        "author": "Adam D. Schuyler, Ph.D.",
        "authorTitle": "Assistant Professor of Molecular Biology and Biophysics",
        "authorEmail": "schuyler@uchc.edu",
        "authorPhotoUrl": "assets/community/blog-author.jpg",
        "dateCurrent": false
      },
      {
        "contentType": "blog",
        "id": 18,
        "name": "Old Blog Post",
        "synopsis": "Synopsis goes here...",
        "description": "Article content will go here....",
        "url": "assets/community/blog-9.jpg",
        "author": "Adam D. Schuyler, Ph.D.",
        "authorTitle": "Assistant Professor of Molecular Biology and Biophysics",
        "authorEmail": "schuyler@uchc.edu",
        "authorPhotoUrl": "assets/community/blog-author.jpg",
        "dateCurrent": false
      }
    ];

    let comEventsList = [

      {
        "contentType": "event",
        "id": 33,
        "dateEvent":"Jul 8, 2017",
        "name": "CUNY Advanced Science Research",
        "synopsis": "Synopsis goes here",
        "description": "Article content will go here....",
        "url": "assets/community/events-4.jpg",
        "dateCurrent": true,
        "nmrbox_version":"5.1",
        "software_version":"6.5",
        "software_types": ['spectral']
      },
      {
        "contentType": "event",
        "id": 10,
        "dateEvent":"Aug 22, 2017",
        "name": "The Scripps Research Institute",
        "synopsis": "Join other members of the NMR research community...",
        "description": "Event content will go here....",
        "url": "assets/community/events-1.jpg",
        "dateCurrent": true,
        "nmrbox_version":"5.1",
        "software_version":"11.0.5",
        "software_types": ['spectral','assignment','relaxation','chemical-shift','molecular-modeling','structure','residual-dipole-coupling']
      },
      {
        "contentType": "event",
        "id": 31,
        "dateEvent":"Sep 26-19, 2017",
        "name": "Annual Summer Workshop",
        "synopsis": "Brief synopsis",
        "description": "Article content will go here....",
        "url": "assets/community/events-2.jpg",
        "dateCurrent": true,
        "nmrbox_version":"5.1",
        "software_version":"6.5",
        "software_types": ['spectral']
      },
      {
        "contentType": "event",
        "id": 32,
        "dateEvent":"July 23-28, 2016",
        "name": "ISMAR Quebec City",
        "synopsis": "Synopsis goes here",
        "description": "Article content will go here....",
        "url": "assets/community/events-3.jpg",
        "dateCurrent": false,
        "nmrbox_version":"5.1",
        "software_version":"6.5",
        "software_types": ['spectral']
      },
      {
        "contentType": "event",
        "id": 34,
        "dateEvent":"Nov 4, 2016",
        "name": "CANMRGD Meeting",
        "synopsis": "Synopsis goes here",
        "description": "Article content will go here....",
        "url": "assets/community/events-5.jpg",
        "dateCurrent": false,
        "nmrbox_version":"5.1",
        "software_version":"6.5",
        "software_types": ['spectral']
      },
      {
        "contentType": "event",
        "id": 35,
        "dateEvent":"Sep 1-4, 2016",
        "name": "Experimental NMR Conference",
        "synopsis": "Synopsis goes here",
        "description": "Article content will go here....",
        "url": "assets/community/events-6.jpg",
        "dateCurrent": false,
        "nmrbox_version":"5.1",
        "software_version":"6.5",
        "software_types": ['spectral']
      },
      {
        "contentType": "event",
        "id": 36,
        "dateEvent":"Dec 8, 2016",
        "name": "CUNY Advanced Science Research",
        "synopsis": "Synopsis goes here",
        "description": "Article content will go here....",
        "url": "assets/community/events-7.jpg",
        "dateCurrent": false,
        "nmrbox_version":"5.1",
        "software_version":"6.5",
        "software_types": ['spectral']
      },
      {
        "contentType": "event",
        "id": 37,
        "dateEvent":"Nov 4, 2016",
        "name": "CANMRGD Meeting",
        "synopsis": "Synopsis goes here",
        "description": "Article content will go here....",
        "url": "assets/community/events-8.jpg",
        "dateCurrent": false,
        "nmrbox_version":"5.1",
        "software_version":"6.5",
        "software_types": ['spectral']
      },
      {
        "contentType": "event",
        "id": 38,
        "dateEvent":"Sep 1-4, 2016",
        "name": "Experimental NMR Conference",
        "synopsis": "Synopsis goes here",
        "description": "Article content will go here....",
        "url": "assets/community/events-9.jpg",
        "dateCurrent": false,
        "nmrbox_version":"5.1",
        "software_version":"6.5",
        "software_types": ['spectral']
      }
    ];
    
    let swtList = [
      { "id": "sw-spectral", "name": "spectral"},
      { "id": 'sw-assignment', "name": "assignment" },
      { "id": 'sw-relaxation', "name": "relaxation" },
      { "id": 'sw-chemical-shift', "name": "chemical-shift" },
      { "id": 'sw-molecular-modeling', "name": "molecular-modeling" },
      { "id": 'sw-structure', "name": "structure"},
      { "id": 'sw-rdc', "name": "rdc" }
    ];

    return {softwareList, comSupportList, comBlogList, comEventsList, swtList};
  }
}