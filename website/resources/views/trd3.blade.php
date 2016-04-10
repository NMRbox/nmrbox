@extends('layouts.default')

{{-- Page title --}}
@section('title')
    TRD 3
    @parent
    @stop

    {{-- page level styles --}}
    @section('header_styles')
    @stop


    {{-- Page content --}}
    @section('content')
            <!-- Container Section Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">

                <div class="research-header">
                    <h1>Technology Research and Development - TR&D 3</h1>
                    <span>NMRBox Analytics: Bayesian Inference</span>
                </div>

                <div class="research-container">
                    <h2>Summary</h2>

                    <p>
                        Biological applications of NMR have expanded to include broad areas of investigation in structural biology, metabolic studies, disease diagnosis, and drug discovery. NMR offers detailed information, but the interpretation involves a multistep and intricate process that uses a range of mathematical and computational methods. Powerful software packages have been developed to facilitate data collection, analysis, and interpretation, but significant challenges remain. Our aim is to deliver a robust and reliable statistical framework, based on Bayesian principles, in order to advance the state of NMR data analytics, simplify the future development of advanced NMR applications that use statistical principles, and provide significant new applications of this framework in the context of NMR. Central components of this effort include: a) the realization of a Bayesian inference engine and a set of programming interfaces called PINE-API, b) the redeployment of some legacy applications on the new platform, and c) provisioning of templates for development of applications by other research teams. The implementation of this technology will benefit from key advantages offered by the NMRbox platform. The benefits to the developer community include significantly lowered barriers to the use of Bayesian methodology in their application development, substantially reduced time for development of new applications, broader accessibility to a host of tools without the need for installation and management, and higher visibility of resulting software tools through the NMRbox dashboard. The end-user in the NMR community will benefit as well. By facilitating the deployment, utilization, interoperation, and persistence of this advanced technology, the proposed development will advance the application of NMR for a wide range of challenging applications in biomedicine, and help ensure the reproducibility bio-NMR studies.
                    </p>

                    <img src="{{ asset('assets/img/replicability-reproducibility.png') }}" alt="replicability-reproducibility">
                    <p class="caption">Figure. A continuum of requirements spans the needs from replication to reproducibility. VMs provide straightforward solutions to replication needs, and some reproducibility requirements. TRD 3 is focused on providing an intrinsic measure for replication and reproducibility using the Bayesian approach, providing applications, and tools for capturing data.</p>



                    <h2>Overview</h2>
                    <p>
                        TR&D 3 addresses a key need for significantly improveming the pace and yield of NMR-based research. In practice, the need has come about as a result of real-world experience in more intricate studies, in which a combination of experimental data, semi-automated processes, expert knowledge, side information (prior), and assumptions, as well as expert-level review is used to reach results. In order to merge the various pieces of information into a coherent result, it is therefore often necessary to use inference. By delivering an inference engine, software tools, and templates that enable advanced development of novel Bayesian software tools for NMR spectroscopy, TR&D 3 will streamline the creation of necessary inference tools. NMR metabolomics studies, a rapidly evolving area of NMR application has similar needs for a robust approach. In the past, continual changes to computational resources, platforms, tools, data formats, and scripts to support procedures of experimental approach has posed a major obstacle for rigorous and reproducible examination of results in biomolecular system studies. TR&D 3 proposes the development of a portable and stable inference core, PINE-API, that builds on the solid strengths of the existing methodology and core technology developed in PINE. To enable quantitative investigations into repeatability and reproducibility, and to provide a measure of support for results derived from experimental data, we will provide application interfaces that facilitate the combining of the use of the inference engine with the workflow tools and databases interface provided in TR&D 2.  Several DBPs and related collaborations will drive and guide our development.  We welcome new collaborations.
                    </p>

                    <h2>Innovative Ideas</h2>
                    <p>
                        TR&D 3 will deliver an advanced, portable, and stable platform capable of reproducing and reusing data and software. Three contributing factors are: 1) the stable and functional base environment, as proposed in TR&Ds 1 and TR&D 2, 2) the use of open source technologies, and 3) the distinctive computational approach used in our earlier developments. The probabilistic model in PINE-API is ideally suited for multistep, multiple-tool, NMR investigations; leading to a reduced potential for error, and maximized efficiencies. We will streamline further probabilistic application developments by delivering a platform that provides access to discrete computational tools, provides support for simple yet powerful operational scripts, contains templates to speed up development of new applications, and uses a universally portable platform for development and testing. Moreover, PINE-API will address the necessary functionality for improving reproducibility by offering quantitative measures for evaluting inferential steps. The platform is open source, thus enabling the sharing with the broader community the unique base of knowledge and algorithms in PINE-API; potentially inspiring new Bayesian applications.
                    </p>

                    <h2>Key Objectives</h2>
                    <p>
                        <strong>Deliver PINE-API, a new flexible inference core that supports robust probabilistic inference.</strong> PINE-API will deliver a Bayesian inference core in an open source and virtualized platform offering portability and access. It will use the NMR-STAR data model and will be designed for integration with the CONNJUR workflow framework.
                    </p>
                    <p>
                        <strong> Provide advanced tools for inference-based bio-NMR that serve as templates as well significant applications.</strong> New applications focused on emerging areas of NMR-based investigation will be provided.
                    </p>
                    <p>
                        <strong> Integrate the operations of TR&D 3 applications with CONNJUR, through a simple yet powerful user interface.</strong> The system will be designed to enable future streamlining and “packaging” of common NMR experiments in bioNMR with the added capability of repeating and reproducing computations – optionally with altered parameters.
                    </p>

                    <img src="{{ asset('assets/img/pine-api.png') }}" alt="pine-api">
                    <p class="caption">Figure. The component roadmap for TRD3 identifies the central inference engine, PINE-API, the data transform and capture layer that communicates with all applications, and the application areas to be developed. Applications contain the data and inference instructions.  Inference instructions are passed to the PINE-API engine directly while the data transform layer perform any needed transformation of data before transferring it to the PINE-API core engine.</p>

                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
