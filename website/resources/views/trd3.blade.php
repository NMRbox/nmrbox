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
                    <h1>TRD 3</h1>
                    <span>NMRBox Analytics: Bayesian Inference</span>
                </div>

                <div class="research-container">
                    <h2>Abstract</h2>

                    <p>
                        Biological applications of NMR have expanded to include broad areas of investigation in structural biology, metabolic studies, disease diagnosis, and drug discovery. NMR offers detailed information, but the interpretation involves a multistep and intricate process that uses a range of mathematical and computational methods. Powerful software packages have been developed to facilitate data collection, analysis, and interpretation, but significant challenges remain. The aim of this TRD is to deliver a robust and reliable statistical framework, based on Bayesian principles, in order to advance the state of NMR data analytics, simplify the future development of advanced NMR applications that use statistical principles, and provide significant new applications of this framework in the context of NMR. Central components of this TRD include the development of a Bayesian inference engine and a set of programming interfaces, the redeployment of some legacy applications on the new platform, provide templates for development of applications by other research teams, and integration of the technology within the platform being developed by the Center. The implementation of this TRD will benefit from key advantages offered by the NMRbox platform. The resulting Bayesian inference technology will see significantly lowered barriers to use, substantially reduced time for development of new applications, broader accessibility, and higher visibility. By facilitating the deployment, utilization, interoperation, and persistence of this advanced technology, the proposed TRD will advance the application of NMR for a wide range of challenging applications in biomedicine, and help ensure the reproducibility bio-NMR studies.
                    </p>

                    <img src="{{ asset('assets/img/replicability-reproducibility.png') }}" alt="replicability-reproducibility">
                    <p class="caption">Figure. A continuum of requirements spans the needs from replication to reproducibility. VMs provide straightforward solutions to replication needs, and some reproducibility requirements. TRD 3 is focused on providing an intrinsic measure for replication and reproducibility using the Bayesian approach, providing applications, and tools for capturing data.</p>



                    <h2>Summary</h2>
                    <p>
                        TR&D 3 addresses one of the recognized needs for significant improvements in the pace and yield of NMR processes by delivering an inference engine, software tools, and templates that enable advanced development of novel Bayesian software tools for NMR spectroscopy. In practice, the need has come about as a result of real-world experience in more intricate studies, in which a combination of experimental data, semi-automated processes, expert knowledge, side information (prior), and assumptions, as well as expert-level review is used to reach results. NMR metabolomics studies, a rapidly evolving area, have similar needs for a robust approach. However, continual changes to computational resources, platforms, tools, data formats, and scripts to support procedures of experimental approach pose a major obstacle for rigorous and reproducible examination of results in biomolecular system studies. TR&D 3 proposes the development of a portable and stable inference core, PINE-API, that builds on the solid strengths of the existing methodology and core technology developed in PINE. This core supports development of applications through a set of plug-in interfaces and templates. As part of this research, a set of new applications that parallel our present inference-based software tools will be renovated by implementing them on the base of PINE-API. A new application that demonstrates the unique power of Bayesian methodology will be developed. This application will focus on metabolite identification and quantification. To enable quantitative investigations into repeatability and reproducibility, and to provide a measure of support for results derived from experimental data, we will provide application interfaces that facilitate the combining of the use of the inference engine with the workflow tools and databases interface provided in TR&D 2.  Several DBPs will drive and guide our development.
                    </p>

                    <h2>Innovation</h2>
                    <p>
                        TR&D 3 will deliver an advanced, portable, and stable platform capable of reproducing and reusing data and software. Three contributing factors are: 1) the stable and functional base environment, as proposed in TR&Ds 1 and 2, 2) the use of open source technologies, and 3) the distinctive computational approach used in our earlier developments. PINE-API relies on rigorous principles and advanced mathematical approaches to achieve efficiency and robustness at the same time. We will streamline further probabilistic application development by delivering a platform that provides access to discrete computational tools, provides support for simple yet powerful operational scripts, contains templates to speed up development of new applications, and uses a universally portable platform for development and testing. PINE-API will be the first tool in the bioNMR community to address functions that improve reproducibility and reusability by offering a quantitative measure within a statistical platform.  Automation through Bayesian inference, and within a flexible and robust scientific environment will contribute to advancements in the field. The probabilistic model in PINE-API is ideally suited for multistep, multiple-tool, NMR investigations; leading to a reduced potential for error, and maximized efficiencies. The platform is open source, thus enabling the sharing with the broader community the unique base of knowledge and algorithms in PINE-API; potentially inspiring new Bayesian applications.
                    </p>

                    <h2>Specific Aims</h2>
                    <p>
                        <strong>Aim T3.1:  Innovate the technology developed in PINE to deliver PINE-API, a new flexible inference core that supports robust probabilistic inference.</strong> PINE-API will deliver a Bayesian inference core in an open source and virtualized platform offering portability and access. It will use the NMR-STAR data model and will be designed for integration with the CONNJUR workflow framework.  Using PINE-API, a new implementation for secondary structure determination, chemical shift assignment, and verification will be provided.  In addition to increase functionality, these new applications will offer a documented template, and a roadmap, to encourage and streamline new developments of Bayesian applications by the user/developer community.
                    </p>
                    <p>
                        <strong>Aim T3.2: Provide advanced tools for inference-based bio-NMR that serve as templates as well significant applications.</strong> A new application focused on metabolomics will be provided. In addition, an advanced assignment application template that provides comprehensive “network-based” approach for proteins and RNA will be designed. The metabolomics application will provide for metabolite identification and quantification by using inference-based interpretation of 1D NMR spectra – as optional input, it will accept identification and relative quantification results obtained from alternative platforms such as MS.
                    </p>
                    <p>
                        <strong>Aim T3.3: Integrate the operations of all TRD 3 applications with CONNJUR, through a simple yet powerful user interface.</strong> PINE-API will be designed so that it can be integrated into any software in order to provide Bayesian inference capabilities. T3.3 integrates PINE-API with CONNJUR function, adds an easy to use user interface (UI). The system will be designed to enable future streamlining and “packaging” of common NMR experiments in bioNMR with the added capability of repeating and reproducing computations – optionally with altered parameters. Enabling functions for subsequent integration of the resulting posterior distribution and presentation of the reliability results will be provided.
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
