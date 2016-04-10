<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NmrSql extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        --
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = \'UTF8\';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plperl; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: postgres
--

CREATE OR REPLACE PROCEDURAL LANGUAGE plperl;


ALTER PROCEDURAL LANGUAGE plperl OWNER TO postgres;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS \'PL/pgSQL procedural language\';


SET search_path = public, pg_catalog;

--
-- Name: software_name_upper(); Type: FUNCTION; Schema: public; Owner: laravel
--

CREATE FUNCTION software_name_upper() RETURNS trigger
    LANGUAGE plperl
    AS $_X$use strict;

                my $nname = $_TD->{new}{name};

                my $asupper = uc $nname;

                if ($asupper eq $nname) {
                   return;

                }
                $_TD->{new}{name} = $asupper;

                return "MODIFY";
                $_X$;


ALTER FUNCTION public.software_name_upper() OWNER TO laravel;

--
-- Name: software_vers_proc(character varying, character varying); Type: FUNCTION; Schema: public; Owner: laravel
--

CREATE FUNCTION software_vers_proc(character varying, character varying) RETURNS integer
    LANGUAGE plperl
    AS $_$
	my $softwarename = uc shift;
    my $versionname =  shift;
	my $sw = spi_exec_query(\'select id from software where name =\' . quote_literal($softwarename),1);
	my $sid; 
	if ($sw->{processed} == 1) {
		$sid =  $sw->{rows}[0]->{id};
	}
	else {
		my $n = $softwarename;
		my $insertSQL = sprintf("insert into software(name,long_title,synopsis,description) values(\'%s\',\'%s\',\'tbd\',\'tbd\') returning id",$n,$n);
		elog(NOTICE,$insertSQL);
		my $si = spi_exec_query($insertSQL,1);
		my $stat = $si->{status};
		if ($stat ne SPI_OK_INSERT_RETURNING) {
			elog(ERROR,"bad software insert ". $stat);
		}
		$sid =  $si->{rows}[0]->{id};
	}

	my $selectSql = "select id from software_versions where software_id = $sid and version =" . quote_literal($versionname);
	$sw = spi_exec_query($selectSql,1);
	if ($sw->{processed} == 1) {
		return $sw->{rows}[0]->{id};
	}
	my $insertSQL = \'insert into software_versions(version,software_id) values(\' . quote_literal($versionname) . ",$sid) returning id";
	my $si = spi_exec_query($insertSQL,1);
	my $stat = $si->{status};
	if ($stat ne SPI_OK_INSERT_RETURNING) {
		elog(ERROR,"bad software_vers insert ". $stat);
	}
	return $si->{rows}[0]->{id};
$_$;


ALTER FUNCTION public.software_vers_proc(character varying, character varying) OWNER TO laravel;

SET default_tablespace = \'\';

SET default_with_oids = false;

--
-- Name: activations; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE activations (
    id integer NOT NULL,
    user_id integer NOT NULL,
    code character varying(255) NOT NULL,
    completed boolean DEFAULT false NOT NULL,
    completed_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.activations OWNER TO laravel;

--
-- Name: activations_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE activations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.activations_id_seq OWNER TO laravel;

--
-- Name: activations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE activations_id_seq OWNED BY activations.id;


--
-- Name: blog_categories; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE blog_categories (
    id integer NOT NULL,
    title character varying(255) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.blog_categories OWNER TO laravel;

--
-- Name: blog_categories_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE blog_categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.blog_categories_id_seq OWNER TO laravel;

--
-- Name: blog_categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE blog_categories_id_seq OWNED BY blog_categories.id;


--
-- Name: blog_comments; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE blog_comments (
    id integer NOT NULL,
    blog_id integer NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    website character varying(255),
    comment text NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.blog_comments OWNER TO laravel;

--
-- Name: blog_comments_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE blog_comments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.blog_comments_id_seq OWNER TO laravel;

--
-- Name: blog_comments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE blog_comments_id_seq OWNED BY blog_comments.id;


--
-- Name: blogs; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE blogs (
    id integer NOT NULL,
    blog_category_id integer NOT NULL,
    user_id integer NOT NULL,
    title character varying(255) NOT NULL,
    content text NOT NULL,
    image character varying(255),
    views integer DEFAULT 0 NOT NULL,
    slug character varying(255),
    featured smallint NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.blogs OWNER TO laravel;

--
-- Name: blogs_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE blogs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.blogs_id_seq OWNER TO laravel;

--
-- Name: blogs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE blogs_id_seq OWNED BY blogs.id;


--
-- Name: citation_person; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE citation_person (
    person_id integer NOT NULL,
    citation_id integer NOT NULL
);


ALTER TABLE public.citation_person OWNER TO laravel;

--
-- Name: citation_software; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE citation_software (
    software_id integer NOT NULL,
    citation_id integer NOT NULL
);


ALTER TABLE public.citation_software OWNER TO laravel;

--
-- Name: citation_types; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE citation_types (
    id integer NOT NULL,
    name character varying(32) NOT NULL
);


ALTER TABLE public.citation_types OWNER TO laravel;

--
-- Name: citation_types_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE citation_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.citation_types_id_seq OWNER TO laravel;

--
-- Name: citation_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE citation_types_id_seq OWNED BY citation_types.id;


--
-- Name: citations; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE citations (
    id integer NOT NULL,
    citation_type_id integer NOT NULL,
    title character varying(256),
    author character varying(2000),
    year smallint,
    journal character varying(128) NOT NULL,
    volume character varying(10),
    issue character varying(10),
    page_start character varying(10),
    page_end character varying(10),
    publisher character varying(64) NOT NULL,
    pubmed integer,
    note character varying(1000)
);


ALTER TABLE public.citations OWNER TO laravel;

--
-- Name: citations_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE citations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.citations_id_seq OWNER TO laravel;

--
-- Name: citations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE citations_id_seq OWNED BY citations.id;


--
-- Name: files; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE files (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    slug character varying(128) NOT NULL,
    label character varying(255) NOT NULL,
    bdata bytea,
    size integer NOT NULL,
    mime_type character varying(255),
    software_id integer NOT NULL,
    user_id integer NOT NULL,
    role_id integer NOT NULL
);


ALTER TABLE public.files OWNER TO laravel;

--
-- Name: files_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE files_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.files_id_seq OWNER TO laravel;

--
-- Name: files_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE files_id_seq OWNED BY files.id;


--
-- Name: institutions_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE institutions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.institutions_id_seq OWNER TO laravel;

--
-- Name: institutions; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE institutions (
    id integer DEFAULT nextval(\'institutions_id_seq\'::regclass) NOT NULL,
    institution_type character varying(32),
    name character varying(256) NOT NULL
);


ALTER TABLE public.institutions OWNER TO laravel;

--
-- Name: COLUMN institutions.institution_type; Type: COMMENT; Schema: public; Owner: laravel
--

COMMENT ON COLUMN institutions.institution_type IS \'academic, non-profit, government, other\';


--
-- Name: lab_person; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE lab_person (
    person_id integer NOT NULL,
    lab_id integer NOT NULL,
    developer boolean NOT NULL
);


ALTER TABLE public.lab_person OWNER TO laravel;

--
-- Name: lab_role_person; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE lab_role_person (
    person_id integer NOT NULL,
    lab_role_id integer NOT NULL,
    software_id integer NOT NULL
);


ALTER TABLE public.lab_role_person OWNER TO laravel;

--
-- Name: lab_roles; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE lab_roles (
    id integer NOT NULL,
    name character varying(80) NOT NULL,
    slug character varying(90)
);


ALTER TABLE public.lab_roles OWNER TO laravel;

--
-- Name: lab_roles_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE lab_roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.lab_roles_id_seq OWNER TO laravel;

--
-- Name: lab_roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE lab_roles_id_seq OWNED BY lab_roles.id;


--
-- Name: lab_software; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE lab_software (
    software_id integer NOT NULL,
    lab_id integer NOT NULL
);


ALTER TABLE public.lab_software OWNER TO laravel;

--
-- Name: labs; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE labs (
    id integer NOT NULL,
    name character varying(80) NOT NULL,
    institution character varying(80),
    pi character varying(80)
);


ALTER TABLE public.labs OWNER TO laravel;

--
-- Name: labs_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE labs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.labs_id_seq OWNER TO laravel;

--
-- Name: labs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE labs_id_seq OWNED BY labs.id;


--
-- Name: menu_software; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE menu_software (
    software_id integer NOT NULL,
    menu_id integer NOT NULL
);


ALTER TABLE public.menu_software OWNER TO laravel;

--
-- Name: menus; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE menus (
    id integer NOT NULL,
    label character varying(32) NOT NULL
);


ALTER TABLE public.menus OWNER TO laravel;

--
-- Name: menus_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE menus_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.menus_id_seq OWNER TO laravel;

--
-- Name: menus_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE menus_id_seq OWNED BY menus.id;


--
-- Name: pages; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE pages (
    id integer NOT NULL,
    title character varying(255) NOT NULL,
    user_id integer NOT NULL,
    content text NOT NULL,
    slug character varying(255),
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.pages OWNER TO laravel;

--
-- Name: pages_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE pages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pages_id_seq OWNER TO laravel;

--
-- Name: pages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE pages_id_seq OWNED BY pages.id;


--
-- Name: persistences; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE persistences (
    id integer NOT NULL,
    user_id integer NOT NULL,
    code character varying(255) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.persistences OWNER TO laravel;

--
-- Name: persistences_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE persistences_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.persistences_id_seq OWNER TO laravel;

--
-- Name: persistences_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE persistences_id_seq OWNED BY persistences.id;


--
-- Name: person_software; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE person_software (
    person_id integer NOT NULL,
    software_id integer NOT NULL
);


ALTER TABLE public.person_software OWNER TO laravel;

--
-- Name: persons; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE persons (
    id integer NOT NULL,
    first_name character varying(32) NOT NULL,
    last_name character varying(64) NOT NULL,
    email character varying(256) NOT NULL,
    pi character varying(64),
    nmrbox_acct character varying(32),
    address character varying(128) DEFAULT \'\'::character varying,
    city character varying(64) DEFAULT \'\'::character varying NOT NULL,
    country character varying(64) DEFAULT \'\'::character varying NOT NULL,
    institution_id integer,
    job_title character varying(32) DEFAULT \'\'::character varying,
    state_province character varying(32),
    time_zone_id integer DEFAULT 153 NOT NULL,
    zip_code character varying(32) DEFAULT \'\'::character varying NOT NULL,
    address2 character varying(128),
    address3 character varying(128),
    department character varying(256) DEFAULT NULL::character varying
);


ALTER TABLE public.persons OWNER TO laravel;

--
-- Name: persons_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE persons_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.persons_id_seq OWNER TO laravel;

--
-- Name: persons_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE persons_id_seq OWNED BY persons.id;


--
-- Name: reminders; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE reminders (
    id integer NOT NULL,
    user_id integer NOT NULL,
    code character varying(255) NOT NULL,
    completed boolean DEFAULT false NOT NULL,
    completed_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.reminders OWNER TO laravel;

--
-- Name: reminders_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE reminders_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reminders_id_seq OWNER TO laravel;

--
-- Name: reminders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE reminders_id_seq OWNED BY reminders.id;


--
-- Name: role_users; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE role_users (
    user_id integer NOT NULL,
    role_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.role_users OWNER TO laravel;

--
-- Name: roles; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE roles (
    id integer NOT NULL,
    slug character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    permissions text,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.roles OWNER TO laravel;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.roles_id_seq OWNER TO laravel;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE roles_id_seq OWNED BY roles.id;


--
-- Name: software; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE software (
    id integer NOT NULL,
    name character varying(32) NOT NULL,
    short_title character varying(32),
    long_title character varying(128) NOT NULL,
    synopsis character varying(150) NOT NULL,
    public_release boolean,
    description text,
    license_comment text DEFAULT \'\'::text,
    free_to_redistribute boolean,
    devel_contacted boolean DEFAULT false NOT NULL,
    devel_include boolean,
    custom_license boolean,
    uchc_legal_approve boolean,
    devel_redistrib_doc boolean,
    devel_active boolean,
    contact_id integer,
    devel_redistribute_doc boolean,
    execute_license boolean,
    image bytea,
    modified_license bytea,
    original_license bytea,
    url character varying(256) DEFAULT NULL::character varying,
    slug character varying(128)
);


ALTER TABLE public.software OWNER TO laravel;

--
-- Name: software_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE software_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.software_id_seq OWNER TO laravel;

--
-- Name: software_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE software_id_seq OWNED BY software.id;


--
-- Name: software_tag; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE software_tag (
    software_id integer NOT NULL,
    tag_id integer NOT NULL
);


ALTER TABLE public.software_tag OWNER TO laravel;

--
-- Name: software_version_vm; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE software_version_vm (
    software_version_id integer NOT NULL,
    vm_id integer NOT NULL
);


ALTER TABLE public.software_version_vm OWNER TO laravel;

--
-- Name: software_versions; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE software_versions (
    id integer NOT NULL,
    software_id integer NOT NULL,
    version character varying(60) NOT NULL
);


ALTER TABLE public.software_versions OWNER TO laravel;

--
-- Name: software_versions_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE software_versions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.software_versions_id_seq OWNER TO laravel;

--
-- Name: software_versions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE software_versions_id_seq OWNED BY software_versions.id;


--
-- Name: spreadsheet; Type: TABLE; Schema: public; Owner: gweatherby; Tablespace: 
--

CREATE TABLE spreadsheet (
    id integer NOT NULL,
    "Title" character varying(256),
    "Priority" character varying(256),
    "email blast" character varying(256),
    "email response" character varying(256),
    "Salutation (Jeff)" character varying(256),
    "Name" character varying(256),
    "Email" character varying(256),
    "Additional Name" character varying(256),
    "Additional Email" character varying(256),
    "Addintional Name" character varying(256),
    "Additional Email2" character varying(256),
    "Category" character varying(256),
    "Website / Laboratory" character varying(256),
    "in bibdesk" character varying(256),
    "Publication" character varying(256),
    "Publication 2" character varying(256),
    "Publication 3" character varying(256),
    "Installed" character varying(256),
    "Version" character varying(256),
    "Notes" character varying(256),
    "License downloaded" character varying(256),
    "License Type" character varying(256),
    "Free to redistribute" character varying(256),
    "Should be contacted" character varying(256),
    "Contacted" character varying(256),
    "Synopysis" character varying(1024),
    "Full Title" character varying(256)
);


ALTER TABLE public.spreadsheet OWNER TO gweatherby;

--
-- Name: spreadsheet_id_seq; Type: SEQUENCE; Schema: public; Owner: gweatherby
--

CREATE SEQUENCE spreadsheet_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.spreadsheet_id_seq OWNER TO gweatherby;

--
-- Name: spreadsheet_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gweatherby
--

ALTER SEQUENCE spreadsheet_id_seq OWNED BY spreadsheet.id;


--
-- Name: survey; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE survey (
    comments character varying(512),
    desired_software_packages character varying(64)[],
    id integer NOT NULL,
    nmr_imaging boolean DEFAULT false NOT NULL,
    nmr_other character varying(64),
    nmr_solid_state boolean DEFAULT false NOT NULL,
    nmr_solution boolean DEFAULT false NOT NULL,
    persons_id integer,
    study_computational boolean DEFAULT false NOT NULL,
    study_dna boolean DEFAULT false NOT NULL,
    study_dynamics boolean DEFAULT false NOT NULL,
    study_metabolomics boolean DEFAULT false NOT NULL,
    study_other character varying(64),
    study_proteins boolean DEFAULT false NOT NULL,
    study_rna boolean DEFAULT false NOT NULL,
    study_small_molecules boolean DEFAULT false NOT NULL
);


ALTER TABLE public.survey OWNER TO laravel;

--
-- Name: svn_document_software; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE svn_document_software (
    software_id integer NOT NULL,
    svn_document_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.svn_document_software OWNER TO laravel;

--
-- Name: svn_documents; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE svn_documents (
    id integer NOT NULL,
    type character varying(255),
    display smallint,
    bdata bytea
);


ALTER TABLE public.svn_documents OWNER TO laravel;

--
-- Name: svn_documents_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE svn_documents_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.svn_documents_id_seq OWNER TO laravel;

--
-- Name: svn_documents_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE svn_documents_id_seq OWNED BY svn_documents.id;


--
-- Name: taggable_taggables; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE taggable_taggables (
    tag_id integer NOT NULL,
    taggable_id integer NOT NULL,
    taggable_type character varying(255) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.taggable_taggables OWNER TO laravel;

--
-- Name: taggable_tags; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE taggable_tags (
    tag_id integer NOT NULL,
    name character varying(255) NOT NULL,
    normalized character varying(255) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.taggable_tags OWNER TO laravel;

--
-- Name: taggable_tags_tag_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE taggable_tags_tag_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.taggable_tags_tag_id_seq OWNER TO laravel;

--
-- Name: taggable_tags_tag_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE taggable_tags_tag_id_seq OWNED BY taggable_tags.tag_id;


--
-- Name: tags; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE tags (
    id integer NOT NULL,
    keyword character varying(128) NOT NULL
);


ALTER TABLE public.tags OWNER TO laravel;

--
-- Name: tags_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE tags_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tags_id_seq OWNER TO laravel;

--
-- Name: tags_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE tags_id_seq OWNED BY tags.id;


--
-- Name: throttle; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE throttle (
    id integer NOT NULL,
    user_id integer,
    type character varying(255) NOT NULL,
    ip character varying(255),
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.throttle OWNER TO laravel;

--
-- Name: throttle_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE throttle_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.throttle_id_seq OWNER TO laravel;

--
-- Name: throttle_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE throttle_id_seq OWNED BY throttle.id;


--
-- Name: timezones; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE timezones (
    id integer NOT NULL,
    zone character varying(64) NOT NULL
);


ALTER TABLE public.timezones OWNER TO laravel;

--
-- Name: timezones_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE timezones_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.timezones_id_seq OWNER TO laravel;

--
-- Name: timezones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE timezones_id_seq OWNED BY timezones.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE users (
    id integer NOT NULL,
    password character varying(255) NOT NULL,
    permissions text,
    last_login timestamp(0) without time zone,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    deleted_at timestamp(0) without time zone,
    person_id integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.users OWNER TO laravel;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO laravel;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- Name: vms; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
--

CREATE TABLE vms (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    major smallint NOT NULL,
    minor smallint NOT NULL,
    variant smallint NOT NULL
);


ALTER TABLE public.vms OWNER TO laravel;

--
-- Name: vms_id_seq; Type: SEQUENCE; Schema: public; Owner: laravel
--

CREATE SEQUENCE vms_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.vms_id_seq OWNER TO laravel;

--
-- Name: vms_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: laravel
--

ALTER SEQUENCE vms_id_seq OWNED BY vms.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY activations ALTER COLUMN id SET DEFAULT nextval(\'activations_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY blog_categories ALTER COLUMN id SET DEFAULT nextval(\'blog_categories_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY blog_comments ALTER COLUMN id SET DEFAULT nextval(\'blog_comments_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY blogs ALTER COLUMN id SET DEFAULT nextval(\'blogs_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY citation_types ALTER COLUMN id SET DEFAULT nextval(\'citation_types_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY citations ALTER COLUMN id SET DEFAULT nextval(\'citations_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY files ALTER COLUMN id SET DEFAULT nextval(\'files_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY lab_roles ALTER COLUMN id SET DEFAULT nextval(\'lab_roles_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY labs ALTER COLUMN id SET DEFAULT nextval(\'labs_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY menus ALTER COLUMN id SET DEFAULT nextval(\'menus_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY pages ALTER COLUMN id SET DEFAULT nextval(\'pages_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY persistences ALTER COLUMN id SET DEFAULT nextval(\'persistences_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY persons ALTER COLUMN id SET DEFAULT nextval(\'persons_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY reminders ALTER COLUMN id SET DEFAULT nextval(\'reminders_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY roles ALTER COLUMN id SET DEFAULT nextval(\'roles_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY software ALTER COLUMN id SET DEFAULT nextval(\'software_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY software_versions ALTER COLUMN id SET DEFAULT nextval(\'software_versions_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gweatherby
--

ALTER TABLE ONLY spreadsheet ALTER COLUMN id SET DEFAULT nextval(\'spreadsheet_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY svn_documents ALTER COLUMN id SET DEFAULT nextval(\'svn_documents_id_seq\'::regclass);


--
-- Name: tag_id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY taggable_tags ALTER COLUMN tag_id SET DEFAULT nextval(\'taggable_tags_tag_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY tags ALTER COLUMN id SET DEFAULT nextval(\'tags_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY throttle ALTER COLUMN id SET DEFAULT nextval(\'throttle_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY timezones ALTER COLUMN id SET DEFAULT nextval(\'timezones_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval(\'users_id_seq\'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY vms ALTER COLUMN id SET DEFAULT nextval(\'vms_id_seq\'::regclass);


--
-- Data for Name: activations; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY activations (id, user_id, code, completed, completed_at, created_at, updated_at) FROM stdin;
1	1	DPbnbqxi4iDQqUfERMgtFXQcBcRd4Gyi	t	2016-04-05 00:14:10	2016-04-05 00:14:14	2016-04-05 00:14:16
\.


--
-- Name: activations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'activations_id_seq\', 1, false);


--
-- Data for Name: blog_categories; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY blog_categories (id, title, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Name: blog_categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'blog_categories_id_seq\', 1, false);


--
-- Data for Name: blog_comments; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY blog_comments (id, blog_id, name, email, website, comment, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Name: blog_comments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'blog_comments_id_seq\', 1, false);


--
-- Data for Name: blogs; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY blogs (id, blog_category_id, user_id, title, content, image, views, slug, featured, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Name: blogs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'blogs_id_seq\', 1, false);


--
-- Data for Name: citation_person; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY citation_person (person_id, citation_id) FROM stdin;
\.


--
-- Data for Name: citation_software; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY citation_software (software_id, citation_id) FROM stdin;
\.


--
-- Data for Name: citation_types; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY citation_types (id, name) FROM stdin;
\.


--
-- Name: citation_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'citation_types_id_seq\', 1, false);


--
-- Data for Name: citations; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY citations (id, citation_type_id, title, author, year, journal, volume, issue, page_start, page_end, publisher, pubmed, note) FROM stdin;
\.


--
-- Name: citations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'citations_id_seq\', 1, false);


--
-- Data for Name: files; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY files (id, name, slug, label, bdata, size, mime_type, software_id, user_id, role_id) FROM stdin;
\.


--
-- Name: files_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'files_id_seq\', 1, false);


--
-- Data for Name: institutions; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY institutions (id, institution_type, name) FROM stdin;
0	academic	UConn Health
1	\N	Argonne National Laboratory, Argonne, IL
2	\N	University of Wisconsin, Madison
3	\N	National Magnetic Resonance Facility in Madison, Wisconsin
4	\N	Stanford University
5	\N	Max Planck Institute for Biophysical Chemistry
6	\N	The Scripps Research Institute
7	\N	National Magnetic Resonance Facility at Madison, Wisconsin
8	\N	University of Alberta in Edmonton, Alberta, Canada
9	\N	unassigned
10	\N	Columbia University
11	\N	Theoretical Biophysics Group, University of Illinois, Urbana
12	\N	University of Connecticut Health Center
13	\N	University of Cambridge
14	\N	Leibnitz-Institutfür Molekular
15	\N	NIH
16	\N	Molecular Systems, Merck Research Labs, Rahway, NJ, USA
17	\N	National Institutes of Health
\.


--
-- Name: institutions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'institutions_id_seq\', 17, true);


--
-- Data for Name: lab_person; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY lab_person (person_id, lab_id, developer) FROM stdin;
\.


--
-- Data for Name: lab_role_person; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY lab_role_person (person_id, lab_role_id, software_id) FROM stdin;
\.


--
-- Data for Name: lab_roles; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY lab_roles (id, name, slug) FROM stdin;
\.


--
-- Name: lab_roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'lab_roles_id_seq\', 1, false);


--
-- Data for Name: lab_software; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY lab_software (software_id, lab_id) FROM stdin;
\.


--
-- Data for Name: labs; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY labs (id, name, institution, pi) FROM stdin;
\.


--
-- Name: labs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'labs_id_seq\', 1, false);


--
-- Data for Name: menu_software; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY menu_software (software_id, menu_id) FROM stdin;
\.


--
-- Data for Name: menus; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY menus (id, label) FROM stdin;
\.


--
-- Name: menus_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'menus_id_seq\', 1, false);


--
-- Data for Name: pages; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY pages (id, title, user_id, content, slug, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- Name: pages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'pages_id_seq\', 1, false);


--
-- Data for Name: persistences; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY persistences (id, user_id, code, created_at, updated_at) FROM stdin;
3	1	Vj9fOQ6reBZOB2dtPZYEaArqXfkSt6WT	2016-04-06 12:01:24	2016-04-06 12:01:24
\.


--
-- Name: persistences_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'persistences_id_seq\', 3, true);


--
-- Data for Name: person_software; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY person_software (person_id, software_id) FROM stdin;
3	35
4	42
4	34
5	16
6	41
7	46
4	33
8	30
9	47
10	19
11	51
12	53
13	39
14	12
15	27
16	50
17	52
18	17
7	6
19	14
20	7
19	5
21	51
22	43
10	47
19	8
23	37
24	36
25	36
26	16
27	28
28	28
29	32
30	27
31	37
32	19
33	19
34	13
35	13
36	43
37	43
38	24
39	3
40	3
39	33
40	33
39	34
40	34
39	42
40	42
41	35
42	25
43	25
44	17
45	7
46	44
47	21
48	21
49	21
50	22
51	31
52	10
53	10
52	11
53	11
\.


--
-- Data for Name: persons; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY persons (id, first_name, last_name, email, pi, nmrbox_acct, address, city, country, institution_id, job_title, state_province, time_zone_id, zip_code, address2, address3, department) FROM stdin;
1	Admin_first	Admin_last	admin@admin.com	\N	\N				0		\N	153		\N	\N	\N
3	Jonathan J.	Helmus	jjhelmus@gmail.com	\N	\N				1		\N	153		\N	\N	\N
4	John	Markley	markley@nmrfam.wisc.edu	\N	\N				2		\N	153		\N	\N	\N
5	T	Brunger	brunger@stanford.edu	\N	\N				4		\N	153		\N	\N	\N
6	Edward	d\'Auvergne	edward@nmr-relax.com	\N	\N				5		\N	153		\N	\N	\N
7	David	Case	case@biomaps.rutgers.edu.	\N	\N				6		\N	153		\N	\N	\N
8	Jeffrey C.	Hoch	hoch@uchc.edu	\N	\N				0		\N	153		\N	\N	\N
9	Beomsoo	Han	david.wishart@ualberta.ca	\N	\N				8		\N	153		\N	\N	\N
10	David	Wishart	david.wishart@ualberta.ca	\N	\N				9		\N	153		\N	\N	\N
11	Charles	Schwieters	Charles@Schwieters.org	\N	\N				9		\N	153		\N	\N	\N
12	Juuso	Lehtivarjo	juuso.lehtivarjo@uef.fi	\N	\N				9		\N	153		\N	\N	\N
13	Soren	Nielsen	soren.skou.nielsen@gmail.com	\N	\N				9		\N	153		\N	\N	\N
14	Fred	Damberger	damberge@mol.biol.ethz.ch	\N	\N				9		\N	153		\N	\N	\N
15	Arthur G.	Palmer	agp6@columbia.edu	\N	\N				10		\N	153		\N	\N	\N
16	Klaus	Schulten	kschulte@ks.uiuc.edu	\N	\N				11		\N	153		\N	\N	\N
17	Bertram	Ludaescher	ludaesch@illinois.edu	\N	\N				9		\N	153		\N	\N	\N
18	Michael R.	Gryk	gryk@uchc.edu	\N	\N				12		\N	153		\N	\N	\N
19	Michele	Vendruscolo	mv245@cam.ac.uk	\N	\N				13		\N	153		\N	\N	\N
20	Benjamin	Bardiaux	bardiaux@fmp-berlin.de	\N	\N				14		\N	153		\N	\N	\N
21	G	 Marius Clore 	mariusc@intra.niddk.nih.gov	\N	\N				15		\N	153		\N	\N	\N
22	Jeff	Hoch	hoch@uchc.edu	\N	\N				0		\N	153		\N	\N	\N
23	Bruce A.	Johnson	bruce.johnson@asrc.cuny.edu	\N	\N				16		\N	153		\N	\N	\N
24	Frank	Delaglio	delaglio@nih.gov	\N	\N				17		\N	153		\N	\N	\N
25	Ad	Bax	bax@nih.gov	\N	\N				9		\N	153		\N	\N	\N
26	Alex	Brunger	brunger@stanford.edu	\N	\N				9		\N	153		\N	\N	\N
27	Andrej	Sali	sali@salilab.org	\N	\N				9		\N	153		\N	\N	\N
28	Ben	Webb	modeller-care@salilab.org	\N	\N				9		\N	153		\N	\N	\N
29	Andrew	Byrd	byrdra@mail.nih.gov	\N	\N				9		\N	153		\N	\N	\N
30	Arthur	Palmer	agp6@columbia.edu	\N	\N				9		\N	153		\N	\N	\N
31	Bruce	Johnson	bruce.johnson@asrc.cuny.edu	\N	\N				9		\N	153		\N	\N	\N
32	Mark	Berjanskii	mark.berjanskii@ualberta.ca	\N	\N				9		\N	153		\N	\N	\N
33	Yongjie (Jack)	Liang	yongjiel@ualberta.ca	\N	\N				9		\N	153		\N	\N	\N
34	Geerten	Vuister	gv29@leicester.ac.uk	\N	\N				9		\N	153		\N	\N	\N
35	Wayne	Boucher	wb104@cam.ac.uk	\N	\N				9		\N	153		\N	\N	\N
36	Jeffrey	Hoch	hoch@uchc.edu	\N	\N				9		\N	153		\N	\N	\N
37	Alan	Stern	stern@rowland.harvard.edu	\N	\N				9		\N	153		\N	\N	\N
38	Jeffrey	Skolnick	skolnick@gatech.edu	\N	\N				9		\N	153		\N	\N	\N
39	Hamid	Eghbalnia	hamid.eghbalnia@wisc.edu	\N	\N				9		\N	153		\N	\N	\N
40	Woonghee	Lee	whlee@nmrfam.wisc.edu	\N	\N				9		\N	153		\N	\N	\N
41	Jonathan	Helmus	jjhelmus@gmail.com	\N	\N				9		\N	153		\N	\N	\N
42	Mark	Foster	Foster.281@osu.edu	\N	\N				9		\N	153		\N	\N	\N
43	Ian	Kleckner	ian.kleckner@gmail.com	\N	\N				9		\N	153		\N	\N	\N
44	Michael	Gryk	gryk@uchc.edu	\N	\N				9		\N	153		\N	\N	\N
45	Michael	Nilges	michael.nilges@pasteur.fr	\N	\N				9		\N	153		\N	\N	\N
46	https://els.comotion.uw	edu/express_license_technologies/rosetta	license@uw.edu	\N	\N				9		\N	153		\N	\N	\N
47	Nicola	Leone	leone@unical.it	\N	\N				9		\N	153		\N	\N	\N
48	Gerald	Pfeifer	gerald@pfeifer.com	\N	\N				9		\N	153		\N	\N	\N
49	Wolfgang	Faber	wf@wfaber.com	\N	\N				9		\N	153		\N	\N	\N
50	Patrick	Loria	patrick.loria@yale.edu	\N	\N				9		\N	153		\N	\N	\N
51	Paul	Gooley	prg@unimelb.edu.au	\N	\N				9		\N	153		\N	\N	\N
52	Yang	Zhang	yangzhanglab@umich.edu	\N	\N				9		\N	153		\N	\N	\N
53	Jian	Zhang	jianzha@umich.edu	\N	\N				9		\N	153		\N	\N	\N
\.


--
-- Name: persons_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'persons_id_seq\', 53, true);


--
-- Data for Name: reminders; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY reminders (id, user_id, code, completed, completed_at, created_at, updated_at) FROM stdin;
\.


--
-- Name: reminders_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'reminders_id_seq\', 1, false);


--
-- Data for Name: role_users; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY role_users (user_id, role_id, created_at, updated_at) FROM stdin;
1	1	2016-04-05 00:20:30	2016-04-05 00:20:33
\.


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY roles (id, slug, name, permissions, created_at, updated_at) FROM stdin;
1	admin	Admin	{"admin":1}	2016-04-05 00:19:54	2016-04-05 00:19:56
\.


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'roles_id_seq\', 3, true);


--
-- Data for Name: software; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY software (id, name, short_title, long_title, synopsis, public_release, description, license_comment, free_to_redistribute, devel_contacted, devel_include, custom_license, uchc_legal_approve, devel_redistrib_doc, devel_active, contact_id, devel_redistribute_doc, execute_license, image, modified_license, original_license, url, slug) FROM stdin;
4	AESCRYPT	\N	AESCRYPT	tbd	\N	tbd		\N	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
15	CHIMERA	\N	CHIMERA	tbd	\N	tbd		\N	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
18	CPMG_FIT-KORZHNEV	\N	CPMG_FIT-KORZHNEV	tbd	\N	tbd		\N	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
20	DASHA	\N	DASHA	tbd	\N	tbd		\N	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
23	GARANT	\N	GARANT	tbd	\N	tbd		\N	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
26	MATLAB_MCR	\N	MATLAB_MCR	tbd	\N	tbd		\N	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
40	REALVNC	\N	REALVNC	tbd	\N	tbd		\N	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
45	RSTUDIO	\N	RSTUDIO	tbd	\N	tbd		\N	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
48	SITUS	\N	SITUS	tbd	\N	tbd		\N	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
29	MOLMOL	MOLMOL	MOLMOL	MOLMOL: A program for display and analysis of macromolecular structures	\N	tbd		f	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x4554482c20627574202e2e2e	http://sourceforge.net/p/molmol/wiki/Home/	\N
16	CNS	CNS	Crystallography & NMR System	tbd	\N	tbd		f	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x5265737472696374697665	http://cns-online.org/v1.3/	\N
28	MODELLER	\N	MODELLER	tbd	\N	tbd		f	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\\x5265737472696374697665	https://salilab.org/modeller/	\N
32	NESTANMR	\N	NESTANMR	tbd	\N	tbd		t	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\\x474e552047504c7633	http://nestanmr.com/	\N
27	MODELFREE	ModelFree	MODELFREE	ModelFree is a program for optimizing "Lipari-Szabo model free" parameters to heteronuclear relaxation data.	\N	tbd		t	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x474e552047504c322b	http://www.palmer.hs.columbia.edu/software/modelfree.html	\N
52	YESWORKFLOW	yesworkflow	YESWORKFLOW	tbd	\N	tbd		t	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x417061636865207632	https://github.com/yesworkflow-org/yw-prototypes	\N
19	CS-GAMDY	CS-GAMDy	hemical Shift driven Genetic Algorithm for Molecular Dynamics	tbd	\N	tbd		\N	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x4e6f7420666f756e64202d206e6f20726567697374726174696f6e	http://www.gamdy.ca/	\N
51	XPLOR-NIH	Xplor-NIH	XPLOR-NIH	Xplor-NIH is a structure determination program	\N	tbd		f	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x78706c6f722d6e6968	http://nmr.cit.nih.gov/xplor-nih/	\N
6	AMBERTOOLS	ambertools	AMBERTOOLS	tbd	\N	tbd		t	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x616d626572	http://ambermd.org/	\N
46	SHIFTS	SHIFTS	SHIFTS	Program for predicting 15N, 13Ca, 13Cb, and 13C\' chemical shifts from protein structures	\N	tbd		t	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x474e552047504c7633	http://casegroup.rutgers.edu/qshifts/about.htm	\N
41	RELAX	relax	RELAX	Analysis software for Model-free, NMR relaxation (R1, R2, NOE), reduced spectral density mapping, relaxation dispersion	\N	tbd		t	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x474e552047504c	http://www.nmr-relax.com/	\N
12	CARA	CARA	Computer Aided Resonance Assignment	CARA is a software application for the analysis of NMR spectra	\N	tbd		t	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x474e552047504c	http://cara.nmr.ch/doku.php/home	\N
13	CCPNMR-ANALYSIS	\N	CCPNMR-ANALYSIS	tbd	\N	tbd		f	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\\x5265737472696374697665	http://www.ccpn.ac.uk/software/analysis	\N
36	NMRPIPE	NMRPipe	NMRPIPE	Multidimensional spectral processing and analysis of NMR data	\N	tbd		f	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x6e6d7270697065	http://spin.niddk.nih.gov/bax/software/NMRPipe/index.html	\N
37	NMRVIEWJ	NMRViewJ	NMRVIEWJ	The Application for Visualization and Analysis of Macromolecular NMR Software	\N	tbd		f	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x6e6d72766965776a	http://www.onemoonscientific.com/	\N
47	SHIFTX2	shiftx2	SHIFTX2	SHIFTX2 predicts both the backbone and side chain 1H, 13C and 15N chemical shifts for proteins	\N	tbd		\N	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x4e6f7420666f756e64202d206e6f20726567697374726174696f6e	http://www.shiftx2.ca/	\N
43	RNMRTK	RNMRTK	The Rowland NMR Toolkit	Software package for processing multidimensional NMR data	\N	tbd		f	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x726e6d72746b	http://rnmrtk.uchc.edu/rnmrtk/RNMRTK.html	\N
24	GOAP	\N	GOAP	tbd	\N	tbd		t	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\\x66726565	http://cssb.biology.gatech.edu/GOAP/index.html	\N
3	ADAPT-NMR-ENHANCER	\N	ADAPT-NMR-ENHANCER	tbd	\N	tbd		\N	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://pine.nmrfam.wisc.edu/adapt-nmr-enhancer/index.html	\N
33	NEWTON	Newton	NEWTON	A multi-platform, Java-based framework for spectral analysis of multidimensional NMR data.	\N	tbd		\N	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\N	http://www.nmrfam.wisc.edu/newton.htm	\N
34	NMRFAM-SPARKY	NMRFAM-SPARKY	NMRFAM-SPARKY	Sparky is a graphical NMR assignment and integration program for proteins, nucleic acids, and other polymers.	\N	tbd		\N	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\N	http://www.nmrfam.wisc.edu/nmrfam-sparky-distribution.htm	\N
42	RNMR	rNMR	RNMR	rNMR is a software package for visualizing and interpreting one and two dimensional NMR data	\N	tbd		\N	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\N	http://rnmr.nmrfam.wisc.edu	\N
35	NMRGLUE	Nmrglue	NMRGLUE	nmrglue is a module for working with NMR data in Python	\N	tbd		t	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x526564697374726962757465207769746820636f70797269676874	https://github.com/jjhelmus/nmrglue	\N
53	4DSPOT	4dspot	4DSPOT	tbd	\N	tbd		f	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x5265737472696374697665	https://www2.uef.fi/en/4dspot	\N
50	VMD	VMD	Visual Molecular Dynamics	VMD is a molecular visualization program for displaying, animating, and analyzing large biomolecular systems	\N	tbd		f	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x5265737472696374697665	http://www.ks.uiuc.edu/Research/vmd/	\N
25	GUARDD	\N	GUARDD	tbd	\N	tbd		t	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\\x474e552047504c7633	https://research.cbc.osu.edu/foster.281/software/	\N
17	CONNJUR	CONNJUR	CONNJUR	CONNJUR is an open-source framework for software and data integration in bio-NMR.	\N	tbd		t	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x474e552047504c7633	http://connjur.uchc.edu/	\N
7	ARIA	ARIA	Ambiguous Restraints for Iterative Assignment	ARIA is software for automated NOE assignment and NMR structure calculation.	\N	tbd		t	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\\x4e6f206c6963656e7365	http://aria.pasteur.fr/	\N
5	ALMOST	almost	ALMOST	tbd	\N	tbd		t	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x474e552047504c	http://www-almost.ch.cam.ac.uk/site/	\N
8	ARSHIFT	ArShift	ARSHIFT	Structure Based Predictor of Protein Aromatic Side-Chain Proton Chemical Shifts	\N	tbd		t	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x474e552047504c7632	http://www-mvsoftware.ch.cam.ac.uk/index.php/d2D	\N
44	ROSETTA	\N	ROSETTA	tbd	\N	tbd		f	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\\x5265737472696374697665	https://www.rosettacommons.org/software	\N
14	CH3SHIFT	CH3Shift	CH3/methyl chemical  shift predictor	Structure Based Prediction of Protein Methyl Group Chemical Shifts	\N	tbd		t	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x474e552047504c	http://www-sidechain.ch.cam.ac.uk/CH3Shift/	\N
21	DLV	\N	DLV	tbd	\N	tbd		t	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\\x526564697374726962757465207769746820636f70797269676874	http://www.dlvsystem.com/dlv/	\N
49	SQLITE	\N	SQLITE	tbd	\N	tbd		t	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\\x7075626c696320646f6d61696e	http://sqlite.org/	\N
22	FASTMODELFREE	\N	FASTMODELFREE	tbd	\N	tbd		t	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\\x474e552047504c322b	http://xbeams.chem.yale.edu/~loria/software.php	\N
31	NESSY	NESSY	NMR Relaxation Dispersion Spectroscopy Analysis Software	tbd	\N	tbd		t	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x474e552047504c7633	http://home.gna.org/nessy/	\N
39	RAW	raw	RAW	tbd	\N	tbd		t	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x474e552047504c7633	http://sourceforge.net/projects/bioxtasraw/	\N
10	CALRW	\N	CALRW	tbd	\N	tbd		\N	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\\x4e6f7420666f756e64202d206e6f20726567697374726174696f6e	http://zhanglab.ccmb.med.umich.edu/RW/	\N
11	CALRWPLUS	\N	CALRWPLUS	tbd	\N	tbd		\N	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\\x4e6f7420666f756e64202d206e6f20726567697374726174696f6e	http://zhanglab.ccmb.med.umich.edu/RW/	\N
9	ATSAS	\N	ATSAS	tbd	\N	tbd		f	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\\x5265737472696374697665	http://www.embl-hamburg.de/biosaxs/software.html	\N
30	MOSART	MoSART	Molecular Structure Analysis and Refinement Tool	To provide an easily extensible application for computing biomolecular structure from NMR data	\N	tbd		\N	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x4e6f7420666f756e64202d206e6f20726567697374726174696f6e	https://simtk.org/home/mosart	\N
38	PYMOL	PyMOL	PYMOL	A molecular visualization system on an open source foundation, maintained and distributed by Schrödinger.	\N	tbd		\N	f	\N	f	f	\N	t	\N	\N	\N	\N	\N	\\x6f70656e20736f75726365	https://www.pymol.org/	\N
\.


--
-- Name: software_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'software_id_seq\', 53, true);


--
-- Data for Name: software_tag; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY software_tag (software_id, tag_id) FROM stdin;
\.


--
-- Data for Name: software_version_vm; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY software_version_vm (software_version_id, vm_id) FROM stdin;
\.


--
-- Data for Name: software_versions; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY software_versions (id, software_id, version) FROM stdin;
2	3	Build_04-08-2014
3	4	3.10
4	5	2.1.0
5	6	15
6	7	2.3.1
7	8	Downloaded_2015-11-15
8	9	2.7.1
9	10	1.0
10	11	1.0
11	12	1.9.0
12	12	1.9.1.2
13	13	2.4.2
14	14	Downloaded_2015-11-13
15	15	1.10.2
16	16	1.21
17	16	1.3
18	17	BPS2016
19	18	9.0
20	19	1.0
21	20	4.1
22	21	Build_2012-12-17
23	22	1.2
24	23	2.0
25	24	Downloaded_2015-11-13
26	25	2011-09-11
27	26	R2013b
28	26	R2014b
29	26	R2015b
30	27	4.0
31	28	9.15-1
32	29	2.1-2.6
33	30	1.0
34	31	12.3.1
35	32	1.0
36	33	1.4.10
37	34	Build_10-15-2015
38	35	0.4
39	36	8.2_rev2014.215.21.40
40	37	9.1.0-b39
41	38	1.7.2
42	38	1.7.2.1
43	38	1.7.6.0
44	39	0.99.9.14b
45	40	5.2.3
46	41	4.0.0
47	42	1.1.9
48	43	3.2-106
49	43	3.2-125
50	44	2015.39.58186
51	45	0.99.878
52	46	5.0.1
53	47	1.09A
54	48	2.7.2
55	49	3.9.2
56	50	1.9.2
57	51	2.40
58	52	Build-248
59	53	1.21
\.


--
-- Name: software_versions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'software_versions_id_seq\', 59, true);


--
-- Data for Name: spreadsheet; Type: TABLE DATA; Schema: public; Owner: gweatherby
--

COPY spreadsheet (id, "Title", "Priority", "email blast", "email response", "Salutation (Jeff)", "Name", "Email", "Additional Name", "Additional Email", "Addintional Name", "Additional Email2", "Category", "Website / Laboratory", "in bibdesk", "Publication", "Publication 2", "Publication 3", "Installed", "Version", "Notes", "License downloaded", "License Type", "Free to redistribute", "Should be contacted", "Contacted", "Synopysis", "Full Title") FROM stdin;
1	2D-RDC	\N	yes	yes	Homay	Homayoun Valafar	homayoun@cse.sc.edu	\N	\N	\N	\N	\N	http://ifestos.cse.sc.edu/?q=softwares	\N	http://www.ncbi.nlm.nih.gov/pubmed/19345125	\N	\N	\N	\N	\N	no	\N	?	yes	initial	\N	\N
2	molmol	High	\N	\N	\N	?	\N	\N	\N	\N	\N	Molecular visualzation	\N	yes	http://www.ncbi.nlm.nih.gov/pubmed/8744573	\N	\N	yes	2.1-2.6	\N	\N	ETH, but ...	no	yes	\N	MOLMOL is a molecular graphics program for displaying, analyzing, and manipulating the three-dimensional structure of biological macromolecules, with special emphasis on the study of protein or DNA structures determined by NMR.	\N
3	acme	High	skip	\N	Ad	Ad Bax	bax@nih.gov	Frank Delaglio	\N	\N	\N	Spectrum analysis	http://spin.niddk.nih.gov/NMRPipe/acme/	\N	\N	\N	\N	yes	\N	nmrpipe	\N	nmrpipe	no	yes	Done	Measurement of homonuclear proton couplings from regular 2D COSY spectra	\N
4	dynamo	High	skip	\N	Ad	Ad Bax	bax@nih.gov	\N	\N	\N	\N	Structure determination	http://spin.niddk.nih.gov/NMRPipe/dynamo/	\N	\N	\N	\N	yes	\N	nmrpipe	\N	nmrpipe	no	yes	Done	DYNAMO is a system of software tools and scripts for calculating and evaluating molecular structures. DYNAMO includes a cartesian-coordinate simulated annealing engine, and facilities for NMR homology search to assemble collections of molecular fragments which are consistent with NMR observables. The tools of DYNAMO are accessed via scripts written in the TCL/TK scripting language.	\N
5	mera	High	skip	\N	Ad	Ad Bax	bax@nih.gov	Yang Shen	shenyang@niddk.nih.gov	\N	\N	Structure analysis	http://spin.niddk.nih.gov/bax/	yes	http://link.springer.com/article/10.1007%2Fs10858-015-9971-2#page-1	\N	\N	\N	\N	\N	http://spin.niddk.nih.gov/bax/terms.html	Bax-website	no	yes	Done, but official doc coming	Backbone Torsion Angle Distributions Evaluation in Dynamic and Disordered Proteins from NMR Data	\N
6	mics	High	skip	\N	Ad	Ad Bax	bax@nih.gov	Yang Shen	shenyang@niddk.nih.gov	\N	\N	Secondary strucutre prediction	http://spin.niddk.nih.gov/bax/	yes	http://www.ncbi.nlm.nih.gov/pmc/articles/PMC3357447/	\N	\N	\N	\N	\N	http://spin.niddk.nih.gov/bax/terms.html	Bax-website	no	yes	Done, but official doc coming	Identification of Helix Capping and Beta-turn Motifs from NMR Chemical Shifts	\N
7	nmrdraw	High	skip	\N	Ad	Ad Bax	bax@nih.gov	Frank Delaglio	\N	\N	\N	Spectral processsing	http://spin.niddk.nih.gov/bax/software/NMRPipe/index.html	yes	http://link.springer.com/article/10.1007/BF00197809	\N	\N	yes	8.2_rev2014.215.21.40	nmrpipe	\N	nmrpipe	no	yes	Done	\N	\N
8	alnmr	\N	yes	\N	Josh	Joshua Wand	wand@mail.med.upenn.edu	\N	\N	\N	\N	NUS data processing	http://www.med.upenn.edu/wandlab/methods/sparse_sampling.html	yes	http://link.springer.com/article/10.1007/s10858-011-9584-3	\N	\N	\N	\N	Do not know how to download	no	\N	\N	\N	\N	\N	\N
9	nmrpipe	High	skip	\N	Ad	Ad Bax	bax@nih.gov	Frank Delaglio	\N	\N	\N	Spectral processsing	http://spin.niddk.nih.gov/bax/software/NMRPipe/index.html	same as nmrdraw	http://link.springer.com/article/10.1007/BF00197809	\N	\N	yes	8.2_rev2014.215.21.40	nmrpipe	\N	nmrpipe	no	yes	Done	Multidimensional spectral processing and analysis of NMR data	\N
10	ansig	\N	\N	\N	Per	Per Kraulis	\N	\N	\N	\N	\N	\N	http://rmni.iqfr.csic.es/HTML-manuals/ansig-manual/ansig.html	\N	http://link.springer.com/article/10.1023/A%3A1026729404698	http://www.sciencedirect.com/science/article/pii/0022236489901303	http://www.ncbi.nlm.nih.gov/pubmed/8142349	\N	\N	\N	http://rmni.iqfr.csic.es/HTML-manuals/ansig-manual/obtain_info.html	Restrictive	no	\N	\N	\N	\N
11	apsy-nmr	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-014-9881-8	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
12	aqua	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/BF00228148	\N	\N	\N	\N	Should run through BMRB	\N	\N	\N	\N	\N	\N	\N
13	pales	High	skip	\N	Ad	Ad Bax	bax@nih.gov	Markus Zweckstetter	zweckste@speck.niddk.nih.gov	\N	\N	\N	http://spin.niddk.nih.gov/bax/software/PALES/	yes	http://pubs.acs.org/toc/jacsat/122/15	\N	\N	\N	\N	\N	http://spin.niddk.nih.gov/bax/terms.html	Bax-website	no	yes	Done, but official doc coming	Prediction of ALignmEnt from Structure	\N
14	promega	High	skip	\N	Ad	Ad Bax	bax@nih.gov	Yang Shen	shenyang@niddk.nih.gov	\N	\N	\N	http://spin.niddk.nih.gov/bax/software	yes	http://www.ncbi.nlm.nih.gov/pubmed/20041279	\N	\N	yes	\N	nmrpipe	\N	nmrpipe	no	yes	Done	Prediction of Xaa-Pro peptide bond conformation from sequence and chemical shifts	\N
15	ascom	\N	yes	yes	Bernhard	Bernhard Brutscher	bernhard.brutscher@ibs.fr	Ewen Lescop	lescop@icsn.cnrs-gif.fr	\N	\N	\N	http://www.icsn.cnrs-gif.fr/spip.php?article551&lang=en#ascom	\N	J Am Chem Soc. 2007,14;129(10):2756-2757	\N	\N	\N	\N	\N	\N	academic free - no registration	yes	yes	\N	\N	\N
16	sparta	High	skip	\N	Ad	Ad Bax	bax@nih.gov	\N	\N	\N	\N	Chemical shift prediction	http://spin.niddk.nih.gov/bax/software	yes	http://link.springer.com/article/10.1007/s10858-007-9166-6	\N	\N	yes	\N	nmrpipe	\N	nmrpipe	no	yes	Done	Prediction of Backbone Chemical Shifts from Known Protein Structure	\N
17	asno	1993	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/BF00174613	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
18	atnos	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1023/A%3A1021614115432	\N	\N	\N	\N	Inside UNIO and CYANA	\N	\N	\N	\N	\N	\N	\N
19	sparta+	High	skip	\N	Ad	Ad Bax	bax@nih.gov	Yang Shen	shenyang@niddk.nih.gov	\N	\N	Chemical shift prediction	http://spin.niddk.nih.gov/bax/software	yes	http://link.springer.com/article/10.1007/s10858-010-9433-9	\N	\N	yes	\N	nmrpipe	\N	nmrpipe	no	yes	Done	Improved Prediction of Backbone Chemical Shifts from Known Protein Structure	\N
20	aurelia (Bruker)	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/BF00197807	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
21	auremol-ssa	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://www.ncbi.nlm.nih.gov/pubmed/21459640	\N	\N	\N	Multidimensional spectral processing and analysis of NMR data	\N	\N	\N	\N	\N	\N	\N	\N
22	talos	High	skip	\N	Ad	Ad Bax	bax@nih.gov	\N	\N	\N	\N	Torsion angle prediction	http://spin.niddk.nih.gov/bax/software/TALOS	yes	http://link.springer.com/article/10.1023/A%3A1008392405740	\N	\N	yes	\N	nmrpipe	\N	nmrpipe	no	yes	Done	Prediction of Protein Phi and Psi Angles Using a Chemical Shift Database	\N
23	autoproc/agnus	\N	yes	\N	Guy	Guy Montelione	guy@cabm.rutgers.edu	\N	\N	\N	\N	Spectral processing	http://www-nmr.cabm.rutgers.edu/software/autoproc.htm	\N	\N	\N	\N	\N	\N	\N	yes	Restrictive	no	yes	\N	\N	\N
24	batch	\N	yes	yes	Bernhard	Bernhard Brutscher	bernhard.brutscher@ibs.fr	Ewen Lescop	lescop@icsn.cnrs-gif.fr	\N	\N	\N	http://www.icsn.cnrs-gif.fr/spip.php?article551&lang=en#batch	\N	http://link.springer.com/article/10.1007/s10858-009-9314-2	\N	\N	\N	\N	\N	\N	academic free - no registration	yes	yes	\N	\N	\N
25	bbreader	OLD	\N	\N	Reinhard	Reinhard Wimmer	rw@bio.aau.dk	\N	\N	\N	\N	\N	http://www.bmrb.wisc.edu/bbreader/BBReader.html	\N	http://link.springer.com/article/10.1023/A%3A1018631903764	\N	\N	\N	\N	Hosted at BMRB	?	\N	\N	\N	\N	\N	\N
26	talos-N	High	skip	\N	Ad	Ad Bax	bax@nih.gov	Yang Shen	shenyang@niddk.nih.gov	\N	\N	Torsion angle prediction	http://spin.niddk.nih.gov/bax/software/TALOS	yes	http://link.springer.com/article/10.1007/s10858-013-9741-y	\N	\N	yes	\N	nmrpipe	\N	nmrpipe	no	yes	Done	Protein Backbone and Sidechain Torsion Angles Predicted from NMR Chemical Shifts Using Artificial Neural Networks	\N
27	talos+	High	skip	\N	Ad	Ad Bax	bax@nih.gov	Yang Shen	shenyang@niddk.nih.gov	\N	\N	Torsion angle prediction	http://spin.niddk.nih.gov/bax/software/TALOS	yes	http://link.springer.com/article/10.1007/s10858-009-9333-z	\N	\N	yes	\N	nmrpipe	\N	nmrpipe	no	yes	Done	A Hybrid method for predicting protein backbone torsion angles from NMR chemical shifts	\N
28	Camcoil (WEB)	\N	\N	\N	Michele	Michele Vendruscolo	mv245@cam.ac.uk	\N	\N	\N	\N	Chemical shift prediction	http://www-mvsoftware.ch.cam.ac.uk/index.php/d2D	\N	http://www.ncbi.nlm.nih.gov/pubmed/19852475	\N	\N	\N	\N	\N	\N	Not found	\N	\N	\N	\N	\N
145	pca/pls-da utilities	\N	\N	\N	Bob	Robert Powers	rpowers3@unl.edu	\N	\N	\N	\N	\N	http://bionmr.unl.edu/pca-utils.php	\N	http://www.ncbi.nlm.nih.gov/pmc/articles/PMC3534867/	\N	\N	\N	\N	\N	yes	\N	\N	\N	\N	\N	\N
29	campari	\N	\N	\N	Rohit	Rohit Pappu	pappu@wustl.edu	Andreas Vitalis	a.vitalis@bioc.uzh.ch	\N	\N	Molecular modeling	http://campari.sourceforge.net/index.html	\N	http://www.sciencedirect.com/science/article/pii/S1574140009005039	http://www.ncbi.nlm.nih.gov/pubmed/18506808	\N	\N	2	\N	yes	GNU GPLv2	yes	yes	\N	\N	\N
30	CamSol (WEB)	\N	\N	\N	Michele	Michele Vendruscolo	mv245@cam.ac.uk	\N	\N	\N	\N	Chemical shift prediction	http://www-mvsoftware.ch.cam.ac.uk/index.php/d2D	\N	http://www.ncbi.nlm.nih.gov/pubmed/25451785	\N	\N	\N	\N	\N	?	Not found	\N	\N	\N	\N	\N
31	cns	High	\N	\N	\N	Alex Brunger	brunger@stanford.edu	\N	\N	\N	\N	Structure determination	http://cns-online.org/v1.3/	yes	http://www.ncbi.nlm.nih.gov/pubmed/9757107	\N	\N	yes	1.3	Need to deal with Yale, but Alex is now at Stanford	http://cns-online.org/cns_request/	Restrictive	no	yes, see note	\N	CNS (Crystallography and Nmr System) has been designed to provide a flexible multi-level hierachical approach for the most commonly used algorithms in macromolecular structure determination. Highlights include heavy atom searching, experimental phasing (including MAD and MIR), density modification, crystallographic refinement with maximum likelihood targets, and NMR structure calculation using NOEs, J-coupling, chemical shift, and dipolar coupling data.	\N
32	casa	\N	\N	\N	Erik	Erik Zuiderweg	zuiderwe@umich.edu	\N	\N	\N	\N	\N	http://eos.univ-reims.fr/LSD//JmnSoft/CASA/	\N	http://link.springer.com/article/10.1007/s10858-005-4079-8	\N	\N	\N	\N	Small molecule NMR	\N	\N	\N	\N	\N	\N	\N
33	cns-aria (see CNS)	High	\N	\N	\N	Alex Brunger	brunger@stanford.edu	\N	\N	\N	\N	Structure determination	http://cns-online.org/v1.3/	same as cns	http://www.ncbi.nlm.nih.gov/pubmed/9757107	\N	\N	yes	1.21	\N	http://cns-online.org/cns_request/	Restrictive	no	no	\N	\N	\N
34	modeller	High	yes	yes	Andrej	Andrej Sali	sali@salilab.org	Ben Webb	modeller-care@salilab.org	\N	\N	\N	https://salilab.org/modeller/	yes (no pdf, $)	http://onlinelibrary.wiley.com/doi/10.1002/0471250953.bi0506s47/abstract	\N	\N	\N	\N	Sali lab has several other programs and web services	https://salilab.org/modeller/registration.html	Restrictive	no	yes	\N	\N	\N
35	nestanmr	High	skip	\N	Andy	Andrew Byrd	byrdra@mail.nih.gov	\N	\N	\N	\N	NUS data processing	http://nestanmr.com/	yes	http://link.springer.com/article/10.1007/s10858-015-9923-x	\N	\N	yes	1	\N	yes	GNU GPLv3	yes	yes	Done	\N	\N
36	chemex	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	Relaxation analysis	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
37	chemical shift network analysis	\N	\N	\N	Peter	Peter Wright	wright@scripps.edu	\N	\N	\N	\N	\N	http://www.scripps.edu/wright/?page_id=17	\N	\N	\N	\N	\N	\N	\N	yes	Not found - no registration	?	yes	\N	\N	\N
38	cheshire	\N	\N	\N	Michele	Michele Vendruscolo	mv245@cam.ac.uk	\N	\N	\N	\N	\N	http://www-almost.ch.cam.ac.uk/site/cheshire.html	\N	\N	\N	\N	\N	\N	\N	\N	GNU GPL	yes	yes	\N	\N	\N
39	cing	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-012-9669-7	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
40	CPMGFit (Palmer)	High	yes	\N	Art	Arthur Palmer	agp6@columbia.edu	\N	\N	\N	\N	Relaxation	http://www.palmer.hs.columbia.edu/software/cpmgfit.html	yes	http://www.ncbi.nlm.nih.gov/pubmed/11462813	\N	\N	\N	\N	\N	no	GNU GPL2+	yes	yes	\N	\N	\N
41	curvefit	High	yes	\N	Art	Arthur Palmer	agp6@columbia.edu	\N	\N	\N	\N	\N	http://www.palmer.hs.columbia.edu/software/curvefit.html	\N	\N	\N	\N	\N	\N	\N	yes ?	GNU GPL2+	yes	yes	\N	\N	\N
42	cns-kay-choi	\N	\N	\N	Lewis	Lewis Kay	kay@pound.med.utornonto.ca	James Wing-Yiu Choy	choy@pound.med.utoronto.ca	\N	\N	\N	http://abragam.med.utoronto.ca/software.html	\N	http://link.springer.com/article/10.1023%2FA%3A1011933020122	\N	\N	\N	\N	Cannot find download	no	\N	no	ask	\N	\N	\N
43	modelfree	High	yes	\N	Art	Arthur Palmer	agp6@columbia.edu	\N	\N	\N	\N	Relaxation	http://www.palmer.hs.columbia.edu/software/modelfree.html	yes	http://www.ncbi.nlm.nih.gov/pubmed/7531772	\N	\N	yes	4	\N	yes	GNU GPL2+	yes	yes	\N	ModelFree is a program for optimizing "Lipari-Szabo model free" parameters to heteronuclear relaxation data.	\N
44	yesworkflow	High	yes	yes/ETH	Bertram	Bertram Ludaescher	ludaesch@illinois.edu	\N	\N	\N	\N	\N	https://github.com/yesworkflow-org/yw-prototypes	yes	http://arxiv.org/abs/1502.02403v1	\N	\N	yes	Build-248	\N	yes	Apache v2	yes	yes - Mike	\N	\N	\N
45	contrast	OLD	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/BF00179348	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
46	cpass (WEB)	\N	\N	\N	Bob	Robert Powers	rpowers3@unl.edu	\N	\N	\N	\N	\N	http://cpass.unl.edu/	\N	http://onlinelibrary.wiley.com/doi/10.1002/prot.21092/abstract	http://bmcresnotes.biomedcentral.com/articles/10.1186/1756-0500-4-17	\N	\N	\N	\N	yes	\N	\N	\N	\N	\N	\N
47	nmrviewj	High	skip	\N	Bruce	Bruce Johnson	bruce.johnson@asrc.cuny.edu	\N	\N	\N	\N	Spectrum analysis	http://www.onemoonscientific.com/	same as nmrview	http://link.springer.com/article/10.1007/BF00404272	\N	\N	\N	9.1.0-b39	\N	yes	nmrviewj	no	yes	\N	\N	\N
48	compass	High	yes	yes	Chad	Chad Rienstra	chad.rienstra@gmail.com	Joseph Courtney	joseph.m.courtney@gmail.com	\N	\N	Structure determination	http://www.scs.illinois.edu/rienstra/research/index.html	\N	\N	\N	\N	\N	\N	No software availabe for download yet	no	Not found	?	yes - Mark	\N	\N	\N
49	CROSREL	1992	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/BF02192812	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
50	cs-gamdy	\N	\N	\N	David	David Wishart	david.wishart@ualberta.ca	Mark Berjanskii	mark.berjanskii@ualberta.ca	Yongjie (Jack) Liang	yongjiel@ualberta.ca	Structure refinement	http://www.gamdy.ca/	\N	http://www.ncbi.nlm.nih.gov/pubmed/26345175	\N	\N	\N	\N	Requires many other programs	no	Not found - no registration	?	yes	initial	\N	\N
51	cs-rosetta	\N	\N	\N	Ad	Ad Bax	bax@nih.gov	Yang Shen	shenyang@niddk.nih.gov	\N	\N	Structure determination	http://spin.niddk.nih.gov/bax/	\N	http://www.ncbi.nlm.nih.gov/pubmed/18326625	\N	\N	\N	9	\N	\N	Bax-website	no	yes	Done, but official doc coming	Chemical Shifts Based Protein Structure Prediction Using ROSETTA	\N
52	cs23d (web)	\N	\N	\N	David	David Wishart	david.wishart@ualberta.ca	\N	\N	\N	\N	Automated structure determination	http://www.cs23d.ca/	\N	http://www.ncbi.nlm.nih.gov/pubmed/18515350	\N	\N	\N	\N	\N	no	Web	\N	\N	\N	\N	\N
53	vmd-xplor	High	skip	\N	Charles	Charles Schwieters	Charles@Schwieters.org	\N	\N	\N	\N	Molecular visualization	http://vmd-xplor.cit.nih.gov/	yes	http://www.ncbi.nlm.nih.gov/pubmed/11318623	\N	\N	\N	\N	May be the same license as VMD - need to ask Charles	yes	Restrictive	no	yes, see note	\N	\N	\N
54	csi (web)	\N	\N	\N	David	David Wishart	david.wishart@ualberta.ca	\N	\N	\N	\N	Secondary structure prediction	http://csi.wishartlab.com/cgi-bin/index.py	\N	http://link.springer.com/article/10.1007%2Fs10858-014-9863-x	\N	\N	\N	\N	\N	no	\N	\N	\N	\N	\N	\N
55	csrasrecrozetta	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-014-9833-3	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
56	cssi-pro	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-009-9327-x	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
57	xplor-nih	High	skip	\N	Charles	Charles Schwieters	Charles@Schwieters.org	\N	\N	\N	\N	Structure determination	http://nmr.cit.nih.gov/xplor-nih/	\N	\N	\N	\N	yes	2.4	\N	no	xplor-nih	no	yes	Done	\N	\N
58	cyana	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
59	dasha	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	4.1	\N	\N	\N	\N	\N	\N	\N	\N
60	abacus	High	yes	yes	Cheryl	Cheryl Arrowsmith	carrow@uhnres.utoronto.ca	Alexander Lemak	alemak@uhnres.utoronto.ca	\N	\N	Assignment	http://nmr.uhnres.utoronto.ca/arrowsmith/abacus.html	yes	http://www.ncbi.nlm.nih.gov/pubmed/16080153	http://www.ncbi.nlm.nih.gov/pubmed/18458824	http://www.ncbi.nlm.nih.gov/pubmed/21161328	\N	\N	Ask Irinia for help on info about the program	no	Not found - no registration	?	yes	\N	ABACUS combines assignment of protein NOESY spectra and structure determination by connecting fragments.	\N
61	xeasy	High	yes	\N	Christian	Christian Bartels	christian.bartels@novartis.com	\N	\N	\N	\N	\N	\N	yes (no pdf, $)	http://link.springer.com/article/10.1007/BF00417486	\N	\N	\N	\N	No real home for XEasy	\N	ETH, but ...	no	yes - Mark	\N	\N	\N
62	dynassign	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-008-9291-x	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
63	ehm	\N	\N	\N	Ad	Ad Bax	bax@nih.gov	David Bryce	dbryce@speck.niddk.nih.gov	\N	\N	RDC	http://spin.niddk.nih.gov/bax/	\N	http://www.ncbi.nlm.nih.gov/pubmed/14752260	\N	\N	\N	\N	Program is a spreadsheet, not a binary	http://spin.niddk.nih.gov/bax/terms.html	Bax-website	no	yes	Done, but official doc coming	Extended Histogram Method for Analysis of Dipolar Couplings	\N
64	ensemble	\N	yes	yes	Julie	Julie Forman-Kay	julie.forman-kay@sickkids.ca	Mickael Krzeminski	mickael.krzeminski@sickkids.ca	\N	\N	\N	http://pound.med.utoronto.ca/~JFKlab/	\N	\N	\N	\N	\N	\N	\N	yes	Restrictive	no	yes	High	\N	\N
65	ez-assign	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-013-9778-y	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
66	fanten	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-014-9877-4	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
67	ambertools	High	yes	yes/more info	David	David Case	case@biomaps.rutgers.edu	\N	\N	\N	\N	Structure determination	http://ambermd.org/	yes	http://onlinelibrary.wiley.com/doi/10.1002/jcc.20290/abstract	\N	\N	yes	15	\N	yes	amber	yes	yes	\N	AMBER comprises both a set of empirical force fields (potential energy functions) and a set of software codes for molecular simulation that employ the force fields.	\N
68	fastsax	\N	\N	\N	Ad	Ad Bax	bax@nih.gov	Alexander Grishaev	alexanderg@intra.niddk.nih.gov	\N	\N	SAX	http://spin.niddk.nih.gov/bax/	\N	http://www.ncbi.nlm.nih.gov/pubmed/18787959	\N	\N	\N	\N	\N	http://spin.niddk.nih.gov/bax/terms.html	Bax-website	no	yes	Done, but official doc coming	Fast refinement of macromolecular structures against solution x-ray scattering data	\N
69	fingar	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1023/A%3A1008351824432	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
70	frameworkpeakspin	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	https://sfb.kaust.edu.sa/Pages/Software.aspx	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
71	ftt	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-015-9952-5	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
72	fuda	\N	\N	\N	Lewis	Lewis Kay	kay@pound.med.utornonto.ca	Flemming Hansen	d.hansen@ucl.ac.uk	\N	\N	Spectrum analysis	http://pound.med.utoronto.ca/software.html	\N	\N	\N	\N	\N	\N	\N	no	Not found - no registration	?	yes	\N	\N	\N
73	ga	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/BF00417490	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
74	garant	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2	\N	\N	\N	\N	\N	\N	\N	\N
75	genmr (web)	\N	\N	\N	David	David Wishart	david.wishart@ualberta.ca	\N	\N	\N	\N	Automated structure determination	http://www.genmr.ca/	\N	http://www.ncbi.nlm.nih.gov/pubmed/19406927	\N	\N	\N	\N	\N	no	\N	\N	\N	\N	\N	\N
76	gftnmr	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-014-9814-6	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
77	gifa	\N	\N	\N	Marc-Andre	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/BF00228146	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
78	glove	\N	\N	\N	Peter	Peter Wright	wright@scripps.edu	\N	\N	\N	\N	Relaxation	http://www.scripps.edu/wright/?page_id=17	\N	http://link.springer.com/article/10.1007/s10858-013-9747-5	\N	\N	\N	\N	\N	yes ?	Not found - no registration	?	yes	\N	\N	\N
79	shifts	High	yes	yes/more info	David	David Case	case@biomaps.rutgers.edu	\N	\N	\N	\N	Chemical shift prediction	http://casegroup.rutgers.edu/qshifts/about.htm	yes	http://link.springer.com/article/10.1023/A%3A1013324104681	\N	\N	yes	5.0.1	\N	yes ?	GNU GPLv3	yes	yes	initial	SHIFTS takes a protein structure in Brookhaven (PDB) format, and computes proton chemical shifts from empirical formulas. It can also compute N, Cα, Cβ and C\' shifts in proteins, using a database based on DFT calculations on peptides.	\N
80	gromos	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-011-9534-0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
81	rci (web, stand-alone)	High	yes	yes	David	David Wishart	david.wishart@ualberta.ca	\N	\N	\N	\N	Structure prediction	http://randomcoilindex.com/cgi-bin/rci_cgi_current.py	yes	http://pubs.acs.org/doi/abs/10.1021/ja054842f	\N	\N	\N	\N	\N	no	Not found - no registration	?	yes	\N	\N	\N
82	shiftx2	High	yes	yes	David	David Wishart	david.wishart@ualberta.ca	\N	\N	\N	\N	Chemical shift prediction	http://www.shiftx2.ca/	yes	http://link.springer.com/article/10.1007%2Fs10858-011-9478-4	\N	\N	yes	1.09A	\N	no	Not found - no registration	?	yes	\N	\N	\N
83	homa (web)	\N	\N	\N	Guy	Guy Montelione	guy@cabm.rutgers.edu	\N	\N	\N	\N	Structure validation	http://www-nmr.cabm.rutgers.edu/HOMA/	\N	http://www.ncbi.nlm.nih.gov/pubmed/17640066	\N	\N	\N	\N	\N	no	\N	?	yes	\N	\N	\N
84	hydronmr	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1023/A%3A1016359412284	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
85	ibabel	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
86	ibis	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1023/A%3A1024078926886	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
87	idc	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-006-9009-x	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
88	ididc	\N	\N	\N	Ad	Ad Bax	bax@nih.gov	\N	\N	\N	\N	RDC	http://spin.niddk.nih.gov/bax/	\N	J. Phys. Chem. B 112, 6045-6056 (2008)	\N	\N	\N	\N	\N	http://spin.niddk.nih.gov/bax/terms.html	Bax-website	no	yes	Done, but official doc coming	Iterative DIDC analysis of RDCs	\N
89	imp	\N	\N	\N	Andrej	Andrej Sali	sali@salilab.org	\N	\N	\N	\N	\N	https://integrativemodeling.org/	\N	http://www.ncbi.nlm.nih.gov/pubmed/22272186	\N	\N	\N	\N	\N	yes	LGPL	yes	yes	\N	\N	\N
90	isthms	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-012-9611-z	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
91	jview (legacy - missing)	\N	\N	\N	David	David Wishart	david.wishart@ualberta.ca	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	no	\N	\N	\N	\N	\N	\N
92	knownoe	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1023/A%3A1020279503261	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
93	kujira	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-007-9175-5	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
94	localCIDER	\N	\N	\N	Rohit	Rohit Pappu	pappu@wustl.edu	Alex Holehouse	alex.holehouse@wustl.edu	\N	\N	\N	\N	\N	A.S. Holehouse, R.K. Das, M.G. Richardson, J. Ahad, R.V. Pappu (2015) CIDER: Classification of Intrinsically Disordered Ensemble Regions, http://pappulab.wustl.edu/CIDER (localCIDER version [<version used>])	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
95	lrdc	\N	yes	yes	Jule	Julie Forman-Kay	julie.forman-kay@sickkids.ca	\N	\N	\N	\N	RDC	http://pound.med.utoronto.ca/~JFKlab/	\N	\N	\N	\N	\N	\N	\N	yes	Restrictive	no	yes	High	\N	\N
96	mars	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1023/B%3AJNMR.0000042954.99056.ad	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
97	cpmg-fit (korzhniev)	High	yes	yes	Dmitry	Dmitry Korzhniev	korzhniev@uchc.edu	\N	\N	\N	\N	Relaxation	no website	yes	Reference that software was provided by the laboratory of Dmitry Korzhniev. The first publication using the software is http://www.ncbi.nlm.nih.gov/pubmed/15282609	\N	\N	\N	\N	\N	no	No license	yes	yes - Mark	Done	\N	\N
98	maxocc	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-012-9638-1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
99	mcopa s2	\N	\N	\N	Peter	Peter Wright	wright@scripps.edu	\N	\N	\N	\N	\N	http://www.scripps.edu/wright/?page_id=17	\N	\N	\N	\N	\N	\N	\N	yes	Not found - no registration	?	yes	\N	\N	\N
100	mechano	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	Blackledge	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
101	relax	High	yes	\N	Edward	Edward d\'Auvergne	edward@nmr-relax.com	\N	\N	\N	\N	Relaxation	http://www.nmr-relax.com/	yes	http://link.springer.com/article/10.1007/s10858-011-9509-1	\N	\N	yes	4.0.0	See http://www.nmr-relax.com/manual/Preface_citing_relax.html for details of referencing	yes	GNU GPL	yes	yes	\N	\N	\N
102	mera	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-015-9971-2	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
103	mesmer	\N	yes	\N	Mark	Mark Foster	Foster.281@osu.edu	\N	\N	\N	\N	\N	https://research.cbc.osu.edu/foster.281/software/	\N	http://bioinformatics.oxfordjournals.org/content/early/2015/02/10/bioinformatics.btv079	\N	\N	\N	\N	\N	https://github.com/steelsnowflake/mesmer	GNU GPLv2	yes	\N	\N	\N	\N
104	metaboLab	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1186/1471-2105-12-366	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
105	mfr	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	Part of nmrpipe install	\N	\N	\N	\N	\N	\N	\N
106	mft	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-010-9411-2	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
146	pdbcleaner	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://www-mvsoftware.ch.cam.ac.uk/index.php/pdbcleaner	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
107	catia	High	yes	\N	Flemming	Flemming Hansen	d.hansen@ucl.ac.uk	Lewis Kay	kay@pound.med.utornonto.ca	\N	\N	\N	http://pound.med.utoronto.ca/software.html	yes	http://link.springer.com/article/10.1007/s10858-009-9310-6	\N	\N	\N	\N	\N	no	Not found - no registration	?	yes	\N	\N	\N
108	cara	High	yes	yes	Fred	Fred Damberger	damberge@mol.biol.ethz.ch	Rochus Keller	\N	\N	\N	Spectral analysis	http://cara.nmr.ch/doku.php/home	yes	http://www.cara.nmr-software.org/downloads/3-85600-112-3.pdf	\N	\N	yes	1.9.1.2	\N	yes	GNU GPL	yes	yes	\N	CARA (Computer Aided Resonance Assignment). CARA is a software application for the analysis of NMR spectra and computer aided resonance assignment which is particularly suited for biomacromolecules. Dedicated tools for backbone assignment, side chain assignment, and peak integration support the entire process of structure determination. CARA is precompiled and runs natively on all major platforms in a single executable file for easy installation.	\N
109	ccpnmr-analysis	High	\N	\N	Geerten	Geerten Vuister	gv29@leicester.ac.uk	Wayne Boucher	wb104@cam.ac.uk	\N	\N	Spectral analysis	http://www.ccpn.ac.uk/software/analysis	\N	\N	\N	\N	yes	2002/02/04	\N	yes	Restrictive	no	yes	on-going	\N	\N
110	module2	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
111	hmsist	High	yes	yes	Gerhard	Gerhard Wagner	gerhard_wagner@hms.harvard.edu	Sven Hyberts	sven_hyberts@hms.harvard.edu	\N	\N	NUS data processing	http://gwagner.med.harvard.edu/intranet/hmsIST/	yes	http://www.ncbi.nlm.nih.gov/pubmed/22331404	\N	\N	\N	\N	\N	yes	GNU GPLv3	yes	yes	\N	hmsIST applies iterative soft thresholding to estimate the spectrum for nonuniformly sampled data.	\N
112	molprobity	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-015-9969-9	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
113	monte	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1023/A%3A1021975923026	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
114	asdp	High	yes	\N	Guy	Guy Montelione	guy@cabm.rutgers.edu	Janet Huang	yphuang@cabm.rutgers.edu	\N	\N	Structure determination	http://www-nmr.cabm.rutgers.edu/NMRsoftware/asdp/Home.html	yes	http://onlinelibrary.wiley.com/doi/10.1002/prot.20820/abstract	\N	\N	\N	\N	\N	yes	Restrictive	no	yes	\N	ASDP is an automated NMR NOE assignment engine. It uses a distinct bottom-up topology-constrained approach for iterative NOE interpretation and generates 3D structures of the protein that is as close to the true structure as possible.	\N
115	msTALI	\N	yes	yes	Homay	Homayoun Valafar	homayoun@cse.sc.edu	\N	\N	\N	\N	\N	http://ifestos.cse.sc.edu/?q=softwares	\N	http://www.ncbi.nlm.nih.gov/pmc/articles/PMC3473313/	\N	\N	\N	\N	\N	no	\N	?	yes	initial	\N	\N
116	mulder	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1023/A%3A1021656808607	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
117	munin	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1023/A%3A1012982830367	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
118	mvapack	\N	\N	\N	Bob	Robert Powers	rpowers3@unl.edu	\N	\N	\N	\N	\N	http://bionmr.unl.edu/mvapack.php	\N	http://www.ncbi.nlm.nih.gov/pmc/articles/PMC4033658/	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
119	nD-RDC	\N	yes	yes	Homay	Homayoun Valafar	homayoun@cse.sc.edu	\N	\N	\N	\N	\N	http://ifestos.cse.sc.edu/?q=softwares	\N	http://www.ncbi.nlm.nih.gov/pmc/articles/PMC2669903/	\N	\N	\N	\N	\N	no	\N	?	yes	initial	\N	\N
120	autoassign	High	yes	\N	Guy	Guy Montelione	guy@cabm.rutgers.edu	\N	\N	\N	\N	NMR assingments	http://www-nmr.cabm.rutgers.edu/software/autoassign.htm	yes	http://www.ncbi.nlm.nih.gov/pubmed/9217263	\N	\N	\N	\N	\N	yes	Restrictive	no	yes	\N	\N	\N
121	REDCAT	High	yes	yes	Homay	Homayoun Valafar	homayoun@cse.sc.edu	\N	\N	\N	\N	\N	http://ifestos.cse.sc.edu/?q=softwares	yes	http://www.ncbi.nlm.nih.gov/pubmed/15040978	\N	\N	\N	\N	\N	no	Not found	?	yes	initial	\N	\N
122	REDCRAFT	High	yes	yes	Homay	Homayoun Valafar	homayoun@cse.sc.edu	\N	\N	\N	\N	\N	http://ifestos.cse.sc.edu/?q=softwares	yes	http://www.ncbi.nlm.nih.gov/pubmed/18258464	\N	\N	\N	\N	\N	no	Not found	?	yes	initial	\N	\N
123	cscdp	High	yes	\N	Jim	James Prestegard	jpresteg@ccrc.uga.edu	\N	\N	\N	\N	\N	http://tesla.ccrc.uga.edu/software/	yes	http://www.ncbi.nlm.nih.gov/pubmed/23297019	\N	\N	\N	\N	\N	no	Not found - no registration	?	yes	\N	\N	\N
124	nmrfam-sdf	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-015-9933-8	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
125	rnmrtk	High	yes	\N	Jeff	Jeffrey Hoch	hoch@uchc.edu	Alan Stern	stern@rowland.harvard.edu	\N	\N	Spectral processing	http://rnmrtk.uchc.edu/rnmrtk/RNMRTK.html	yes (no pdf, book)	http://www.wiley.com/WileyCDA/WileyTitle/productCd-0471039004.html	\N	\N	yes	\N	\N	yes	rnmrtk	no	yes	Done	The Rowland NMR Toolkit (RNMRTK) is a general-purpose NMR data processing package. Strengths include non-Fourier methods of spectrum analysis, especially maximum entropy reconstruction	\N
126	goap	High	yes	\N	Jeff	Jeffrey Skolnick	skolnick@gatech.edu	\N	\N	\N	\N	\N	http://cssb.biology.gatech.edu/GOAP/index.html	yes	http://www.ncbi.nlm.nih.gov/pmc/articles/PMC3192975/	\N	\N	yes	Downloaded_2015-11-13	Needed by another program - not NMR specific software	http://cssb.biology.gatech.edu/GOAP/index.html	free	yes	yes	\N	\N	\N
127	nmrkin	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1023/A%3A1014985726029	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
128	adapt-nmr	High	yes	\N	Hamid	Hamid Eghbalnia	hamid.eghbalnia@wisc.edu	Woonghee Lee	whlee@nmrfam.wisc.edu	\N	\N	\N	http://pine.nmrfam.wisc.edu/ADAPT-NMR/	yes	http://link.springer.com/article/10.1007/s10858-015-9950-7	\N	\N	\N	\N	This is for spectrometers	no	\N	?	yes - Hamid	in-progress	\N	\N
129	nmrtoolsoverview	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-013-9750-x	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
130	adapt-nmr-enhancer	High	yes	\N	Hamid	Hamid Eghbalnia	hamid.eghbalnia@wisc.edu	Woonghee Lee	whlee@nmrfam.wisc.edu	\N	\N	\N	http://pine.nmrfam.wisc.edu/adapt-nmr-enhancer/index.html	yes	\N	\N	\N	yes	Build_04-08-2014	\N	no	\N	?	yes - Hamid	\N	\N	\N
131	newton	High	yes	\N	Hamid	Hamid Eghbalnia	hamid.eghbalnia@wisc.edu	Woonghee Lee	whlee@nmrfam.wisc.edu	\N	\N	\N	\N	\N	\N	\N	\N	\N	2010/01/04	\N	no	\N	?	yes - Hamid	\N	\N	\N
132	noenet	\N	yes	\N	Carine	Carine van Heijenoort	carine@icsn.cnrs-gif.fr	\N	\N	\N	\N	\N	http://www.icsn.cnrs-gif.fr/spip.php?article551&lang=en#noenet	\N	http://www.ncbi.nlm.nih.gov/pmc/articles/PMC2813526/	\N	\N	\N	\N	\N	yes ?	\N	\N	\N	\N	\N	\N
133	numbat	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-008-9249-z	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
134	nusscore	\N	\N	\N	Peter	Peter Wright	wright@scripps.edu	\N	\N	\N	\N	\N	http://www.scripps.edu/wright/?page_id=17	\N	\N	\N	\N	\N	\N	\N	yes	Not found - no registration	?	yes	\N	\N	\N
135	nusutils	\N	\N	\N	Bob	Robert Powers	rpowers3@unl.edu	\N	\N	\N	\N	\N	http://bionmr.unl.edu/dgs.php	\N	http://www.sciencedirect.com/science/journal/10907807/261	\N	\N	\N	\N	\N	yes	\N	\N	\N	\N	\N	\N
136	opal	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/BF00211160	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
137	orium	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-013-9775-1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
138	paces	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1023/A%3A1023589029301	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
139	pacsy	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-012-9660-3	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
140	pain	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-013-9756-4	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
141	nmrfam-sparky	High	yes	\N	Hamid	Hamid Eghbalnia	hamid.eghbalnia@wisc.edu	Woonghee Lee	whlee@nmrfam.wisc.edu	\N	\N	\N	\N	yes	\N	\N	\N	yes	Build_10-15-2015	\N	no	\N	?	yes - Hamid	\N	Sparky is a graphical NMR assignment and integration program for proteins, nucleic acids, and other polymers.	\N
142	panav (stand-alone)	\N	\N	\N	David	David Wishart	david.wishart@ualberta.ca	\N	\N	\N	\N	Chemical shift validation	http://panav.wishartlab.com/	\N	http://link.springer.com/article/10.1007/s10858-010-9414-z	\N	\N	\N	\N	\N	no	\N	?	yes	initial	\N	\N
143	parassign	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-013-9743-9	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
144	pasa	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-005-5358-0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
147	pdbstat	\N	yes	\N	Guy	Guy Montelione	guy@cabm.rutgers.edu	\N	\N	\N	\N	\N	http://biopent.uv.es/~roberto/Index.php?sec=pdbstat	\N	http://link.springer.com/article/10.1007/s10858-013-9753-7	\N	\N	\N	\N	\N	no	\N	?	yes	\N	\N	\N
148	PDPA	\N	yes	yes	Homay	Homayoun Valafar	homayoun@cse.sc.edu	\N	\N	\N	\N	\N	http://ifestos.cse.sc.edu/?q=softwares	\N	http://www.ncbi.nlm.nih.gov/pubmed/18321742	\N	\N	\N	\N	\N	no	\N	?	yes	initial	\N	\N
149	pine	High	yes	\N	Hamid	Hamid Eghbalnia	hamid.eghbalnia@wisc.edu	Woonghee Lee	whlee@nmrfam.wisc.edu	\N	\N	\N	\N	yes	\N	\N	\N	\N	\N	\N	no	\N	?	yes - Hamid	\N	PINE uses Bayesian inference to automatically assign protein NMR spectra.	\N
150	pint	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-013-9737-7	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
151	platon	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1023/A%3A1021952400388	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
152	pmag	\N	\N	\N	Nikolai	Nikolai Skrynnikov	nikolai@purdue.edu	\N	\N	\N	\N	Structure determination	https://www.chem.purdue.edu/skrynnikov/software.html	\N	http://www.ncbi.nlm.nih.gov/pubmed/11583547	\N	\N	\N	\N	\N	no	\N	\N	\N	\N	\N	\N
153	pomona	\N	\N	\N	Ad	Ad Bax	bax@nih.gov	\N	\N	\N	\N	Homology modeling	http://spin.niddk.nih.gov/bax/	\N	http://www.nature.com/nmeth/journal/v12/n8/abs/nmeth.3437.html	\N	\N	\N	\N	\N	http://spin.niddk.nih.gov/bax/terms.html	Bax-website	no	yes	Done, but official doc coming	Chemical Shift Homology Modeling using Protein alignments Obtained by Matching Of NMR Assignments	\N
154	ponderosa	High	yes	\N	Hamid	Hamid Eghbalnia	hamid.eghbalnia@wisc.edu	Woonghee Lee	whlee@nmrfam.wisc.edu	\N	\N	\N	\N	yes	\N	\N	\N	\N	\N	\N	no	\N	?	yes - Hamid	\N	\N	\N
155	ppm_one	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-015-9958-z	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
156	pr-calc	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-006-0020-z	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
157	predicts2	\N	\N	\N	Art	Arthur Palmer	agp6@columbia.edu	\N	\N	\N	\N	Relaxation	http://www.palmer.hs.columbia.edu/software/predictS2.html	\N	\N	\N	\N	\N	\N	MAC only	no	\N	\N	no	\N	\N	\N
158	preditor (web)	\N	\N	\N	David	David Wishart	david.wishart@ualberta.ca	\N	\N	\N	\N	Torsion angle prediction	http://wishart.biology.ualberta.ca/shiftor/cgi-bin/preditor_current.py	\N	http://nar.oxfordjournals.org/content/34/suppl_2/W63.abstract	\N	\N	\N	\N	\N	no	\N	\N	\N	\N	\N	\N
159	procheck-nmr	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/BF00228148	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
160	rnmr	High	yes	\N	Hamid	Hamid Eghbalnia	hamid.eghbalnia@wisc.edu	Woonghee Lee	whlee@nmrfam.wisc.edu	\N	\N	\N	\N	\N	\N	\N	\N	\N	2009/01/01	\N	no	\N	?	yes - Hamid	\N	\N	\N
161	prosa	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/BF02192850	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
162	prosess (web)	\N	\N	\N	David	David Wishart	david.wishart@ualberta.ca	\N	\N	\N	\N	Structure validation	http://www.prosess.ca/	\N	http://nar.oxfordjournals.org/content/38/suppl_2/W633.abstract	\N	\N	\N	\N	\N	no	\N	\N	\N	\N	\N	\N
163	proshift	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1023/A%3A1023060720156	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
164	psvs (web)	\N	\N	\N	Guy	Guy Montelione	guy@cabm.rutgers.edu	\N	\N	\N	\N	Structure determination	http://psvs-1_5-dev.nesg.org/	\N	\N	\N	\N	\N	\N	\N	no	\N	?	Talk with Eldon	\N	\N	\N
165	nmrglue	High	yes	\N	Jonathan	Jonathan Helmus	jjhelmus@gmail.com	\N	\N	\N	\N	\N	https://github.com/jjhelmus/nmrglue	yes	http://link.springer.com/article/10.1007%2Fs10858-013-9718-x	\N	\N	yes	0.4	\N	yes	Redistribute with copyright	yes	yes - Mark	\N	\N	\N
166	rasp	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-014-9813-7	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
167	raspec	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-013-9762-6	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
168	4dspot	High	yes	\N	Juuso	Juuso Lehtivarjo	juuso.lehtivarjo@gmail.comjuuso.lehtivarjo@uef.fi ; juuso.lehtivarjo@uku.fi	BAD: juuso.lehtivarjo@uef.fi ; juuso.lehtivarjo@uku.fi	\N	\N	\N	Chemical shift prediction	https://www2.uef.fi/en/4dspot	yes	http://epublications.uef.fi/pub/urn_isbn_978-952-61-1518-4/index_en.html	\N	\N	yes	1.21	\N	yes	Restrictive	no	yes	\N	\N	\N
169	vmd	High	yes	\N	Klaus	Klaus Schulten	kschulte@ks.uiuc.edu	\N	\N	\N	\N	Molecular visualization	http://www.ks.uiuc.edu/Research/vmd/	yes	http://www.ncbi.nlm.nih.gov/pubmed/8744570	\N	\N	yes	2002/01/09	\N	In program directory	Restrictive	no	yes	initial	\N	\N
170	rdca conformist	\N	\N	\N	Nikolai	Nikolai Skrynnikov	nikolai@purdue.edu	\N	\N	\N	\N	\N	https://www.chem.purdue.edu/skrynnikov/software.html	\N	https://www.researchgate.net/publication/222511058_Skrynnikov_NR_et_al_Orienting_domains_in_proteins_using_dipolar_couplings_measured_by_liquid-state_NMR_differences_in_solution_and_crystal_forms_of_maltodextrin_binding_protein_loaded_with_beta-cyclod	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
171	guardd	High	yes	\N	Mark	Mark Foster	Foster.281@osu.edu	Ian Kleckner	ian.kleckner@gmail.com	\N	\N	\N	https://research.cbc.osu.edu/foster.281/software/	yes	http://link.springer.com/article/10.1007/s10858-011-9589-y	\N	\N	\N	\N	Needs MatLab	http://www.gnu.org/licenses/gpl.html	GNU GPLv3	yes	yes	\N	\N	\N
172	connjur	High	\N	\N	Michael	Michael Gryk	gryk@uchc.edu	\N	\N	\N	\N	\N	http://connjur.uchc.edu/	yes	http://www.ncbi.nlm.nih.gov/pubmed/26066803	\N	\N	\N	\N	\N	yes	GNU GPLv3	yes	yes - Mike	Done	CONNJUR is an open-source framework for software and data integration in bio-NMR.	\N
173	aria	High	yes	\N	Michael	Michael Nilges	michael.nilges@pasteur.fr	\N	\N	\N	\N	\N	http://aria.pasteur.fr/	yes	http://www.ncbi.nlm.nih.gov/pubmed/25861734	\N	\N	yes	2001/02/03	\N	yes	No license	yes	yes	\N	ARIA (Ambiguous Restraints for Iterative Assignment) is software for automated NOE assignment and NMR structure calculation. It speeds up the NOE assignment process through the use of ambiguous distance restraints in an iterative structure calculation scheme.	\N
174	relax-jt2	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1023/B%3AJNMR.0000048945.88968.af	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
175	rescue	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1023/A%3A1008338605320	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
176	rfac	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1023/A%3A1008360715569	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
177	rna-pairs	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-012-9603-z	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
178	almost	High	\N	\N	Michele	Michele Vendruscolo	mv245@cam.ac.uk	\N	\N	\N	\N	Molecular simulations	http://www-almost.ch.cam.ac.uk/site/	yes	\N	\N	\N	yes	2000/02/01	\N	yes	GNU GPL	yes	yes	\N	\N	\N
179	ArShift	High	\N	\N	Michele	Michele Vendruscolo	mv245@cam.ac.uk	\N	\N	\N	\N	Chemical shift prediction	http://www-mvsoftware.ch.cam.ac.uk/index.php/d2D	yes	http://www.ncbi.nlm.nih.gov/pubmed/21887824	\N	\N	yes	Downloaded_2015-11-15	\N	yes	GNU GPLv2	yes	yes	\N	Structure Based Predictor of Protein Aromatic Side-Chain Proton Chemical Shifts	\N
180	rosetta	\N	yes	\N	Rosetta Team	https://els.comotion.uw.edu/express_license_technologies/rosetta	license@uw.edu	\N	\N	\N	\N	\N	https://www.rosettacommons.org/software	\N	\N	\N	\N	\N	\N	\N	yes	Restrictive	no	yes	\N	\N	\N
181	rotdif	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-013-9791-1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
182	s2d	\N	\N	\N	Michele	Michele Vendruscolo	mv245@cam.ac.uk	\N	\N	\N	\N	Secondary structure prediction	http://www-mvsoftware.ch.cam.ac.uk/index.php/s2D	\N	http://www.sciencedirect.com/science/article/pii/S002228361400641X	\N	\N	\N	\N	\N	yes	GNU GPL	yes	yes	\N	\N	\N
183	s3epy	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-009-9392-1	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
184	saga	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-010-9403-2	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
185	sail-flya	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-009-9339-6	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
186	sane	\N	\N	\N	Peter	Peter Wright	wright@scripps.edu	\N	\N	\N	\N	NO WEBSITE	\N	\N	http://link.springer.com/article/10.1023/A%3A1011227824104	\N	\N	\N	\N	\N	\N	\N	\N	yes	\N	\N	\N
187	sara	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	NO WEBSITE	\N	http://link.springer.com/article/10.1007/s10858-013-9807-x	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
188	saxs	\N	\N	\N	Ad	Ad Bax	bax@nih.gov	\N	\N	\N	\N	SAX	http://spin.niddk.nih.gov/bax/	\N	http://www.ncbi.nlm.nih.gov/pubmed/16305251	\N	\N	\N	\N	\N	http://spin.niddk.nih.gov/bax/terms.html	Bax-website	no	yes	Done, but official doc coming	Refinement of Protein Structures Against Small-Angle X-Ray Scattering Data	\N
189	script-library	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
190	seascape	Old	yes	\N	Jim	James Prestegard	jpresteg@ccrc.uga.edu	\N	\N	\N	\N	\N	http://tesla.ccrc.uga.edu/software/	\N	\N	\N	\N	\N	\N	\N	no	\N	\N	\N	\N	\N	\N
191	sednmr	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-013-9795-x	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
192	sesame	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/BF00212521	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
193	sherekhan	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	Relaxation analysis	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
194	shiftcor (web)	\N	\N	\N	David	David Wishart	david.wishart@ualberta.ca	\N	\N	\N	\N	Chemical shift validation	http://shiftcor.wishartlab.com/	\N	http://www.ncbi.nlm.nih.gov/pubmed?cmd=Retrieve&dopt=AbstractPlus&list_uids=12652131&query_hl=5&itool=pubmed_docsum	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
195	ch3shift	High	\N	\N	Michele	Michele Vendruscolo	mv245@cam.ac.uk	\N	\N	\N	\N	Chemical shift prediction	http://www-sidechain.ch.cam.ac.uk/CH3Shift/	yes	\N	\N	\N	yes	Downloaded_2015-11-13	\N	\N	GNU GPL	yes	yes	\N	\N	\N
196	shifttor (legacy)	\N	\N	\N	David	David Wishart	david.wishart@ualberta.ca	\N	\N	\N	\N	Torsion angle prediction	http://wishart.biology.ualberta.ca/shiftor/cgi-bin/shiftor_1f.py	\N	http://www.ncbi.nlm.nih.gov/pubmed?Db=pubmed&Cmd=ShowDetailView&TermToSearch=16823900&ordinalpos=1&itool=EntrezSystem2.PEntrez.Pubmed.Pubmed_ResultsPanel.Pubmed_RVBrief	\N	\N	\N	\N	\N	\N	\N	\N	\N	initial	\N	\N
197	shiftx (web, stand-alone)	\N	\N	\N	David	David Wishart	david.wishart@ualberta.ca	\N	\N	\N	\N	Chemical shift prediction	http://shiftx.wishartlab.com/	\N	http://link.springer.com/article/10.1023%2FA%3A1023812930288	\N	\N	\N	\N	Old, use shiftx2 instead	no	\N	\N	\N	initial	\N	\N
198	dlv	High	\N	\N	Nicola	Nicola Leone	leone@unical.it	Gerald Pfeifer	gerald@pfeifer.com	Wolfgang Faber	wf@wfaber.com	\N	http://www.dlvsystem.com/dlv/	\N	\N	\N	\N	yes	Build_2012-12-17	\N	Run dlv -license from NMRbox to get license	Redistribute with copyright	yes	yes	\N	\N	\N
199	shifty (legacy)	\N	\N	\N	David	David Wishart	david.wishart@ualberta.ca	\N	\N	\N	\N	Chemical shift prediction	http://shifty.wishartlab.com/	\N	http://link.springer.com/article/10.1023%2FA%3A1018373822088#page-1	\N	\N	\N	\N	\N	no	\N	\N	\N	initial	\N	\N
200	smile	\N	\N	\N	Ad	Ad Bax	bax@nih.gov	Jinfa Ying	jinfaying@niddk.nih.gov	\N	\N	NUS data processing	http://spin.niddk.nih.gov/bax/	\N	\N	\N	\N	\N	\N	Processing scripts for NUS inside NMRPipe	http://spin.niddk.nih.gov/bax/terms.html	Bax-website	no	yes	Done, but official doc coming	Sparse Multidimensional Iterative Lineshape Enhanced NUS reconstruction	\N
201	matlab-mcr	High	\N	\N	\N	Not needed	\N	\N	\N	\N	\N	\N	\N	yes (no pdf, no pub)	\N	\N	\N	yes	\N	\N	\N	matlab mcr	yes	no	\N	\N	\N
202	sqlite	High	\N	\N	\N	Not needed	\N	\N	\N	\N	\N	\N	http://sqlite.org/	\N	\N	\N	\N	yes	2002/03/09	\N	https://www.sqlite.org/copyright.html	public domain	yes	no	None	\N	\N
203	spinach	\N	yes	yes	Ilya	Ilya Kuprov	i.kuprov@soton.ac.uk	\N	\N	\N	\N	\N	http://spindynamics.org/	\N	http://www.scopus.com/record/display.uri?eid=2-s2.0-79151472769&origin=inward&txGid=0	\N	\N	\N	\N	\N	no	\N	\N	\N	\N	\N	\N
204	spirit	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1023/A%3A1008252526537	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
205	fastmodelfree	High	\N	\N	Pat	Patrick Loria	patrick.loria@yale.edu	\N	\N	\N	\N	\N	http://xbeams.chem.yale.edu/~loria/software.php	yes	http://www.ncbi.nlm.nih.gov/pubmed/12766418	\N	\N	yes	1.2	\N	yes	GNU GPL2+	yes	yes	\N	FASTModelFree is a Perl program to assist in the analysis of laboratory frame spin relaxation data. It interfaces with ModelFree 4.01 (A. G. Palmer, Columbia University) and fully automates the process of model selection and tensor optimization.	\N
206	ssia	\N	\N	\N	Ad	Ad Bax	bax@nih.gov	\N	\N	\N	\N	\N	http://spin.niddk.nih.gov/bax/	\N	http://pubs.acs.org/doi/abs/10.1021/ja0000908?journalCode=jacsat	\N	\N	\N	\N	\N	http://spin.niddk.nih.gov/bax/terms.html	Bax-website	no	yes	Done, but official doc coming	Simulation of Sterically Induced Alignment Tensor	\N
207	ssp	\N	yes	yes	Julie	Julie Forman-Kay	julie.forman-kay@sickkids.ca	\N	\N	\N	\N	\N	http://pound.med.utoronto.ca/~JFKlab/	\N	\N	\N	\N	\N	Build-Nov-2009	\N	yes	Restrictive	no	yes	High	\N	\N
208	stride	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
209	TALI	\N	yes	yes	Homay	Homayoun Valafar	homayoun@cse.sc.edu	\N	\N	\N	\N	\N	http://ifestos.cse.sc.edu/?q=softwares	\N	\N	\N	\N	\N	\N	\N	no	\N	?	yes	initial	\N	\N
210	nessy	High	\N	\N	Paul	Paul Gooley	prg@unimelb.edu.au	\N	\N	\N	\N	Relaxation analysis	http://home.gna.org/nessy/	yes	http://bmcbioinformatics.biomedcentral.com/articles/10.1186/1471-2105-12-421	\N	\N	yes	2001/12/03	\N	\N	GNU GPLv3	yes	yes	\N	\N	\N
211	raw	High	\N	\N	Doren	Soren Nielsen	soren.skou.nielsen@gmail.com	\N	\N	\N	\N	saxs	http://sourceforge.net/projects/bioxtasraw/	yes	http://scripts.iucr.org/cgi-bin/paper?S0021889809023863	\N	\N	yes	0.99.9.14b	\N	yes ?	GNU GPLv3	yes	yes	\N	\N	\N
212	UNIO	High	\N	\N	Torsten	Torsten Herrmann	torsten.herrmann@ens-lyon.fr	\N	\N	\N	\N	Protein structure determination	http://perso.ens-lyon.fr/torsten.herrmann/Herrmann/Software.html	yes	http://www.ncbi.nlm.nih.gov/pubmed/25917899	See manual	http://link.springer.com/article/10.1023/A%3A1021614115432	\N	\N	\N	no	Restrictive	no	yes	\N	\N	\N
213	tatapro	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1023/A%3A1008315111278	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
214	tensor2	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
215	thrifty (legacy - missing)	\N	\N	\N	David	David Wishart	david.wishart@ualberta.ca	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	no	\N	\N	\N	\N	\N	\N
216	topsan	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	TOPSAN: a collaborative annotation environment for structural genomics - Springer	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
217	tsar	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://link.springer.com/article/10.1007/s10858-012-9652-3	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
218	UCSF Chimera	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	https://www.cgl.ucsf.edu/chimera/download.html	\N	\N	\N	\N	\N	2002/01/10	\N	\N	\N	\N	\N	\N	\N	\N
219	UCSF Dock	\N	\N	\N	David	David Case	case@biomaps.rutgers.edu	Likely better contact, but not sure who	\N	\N	\N	\N	http://dock.compbio.ucsf.edu/	\N	\N	\N	\N	\N	6.7	Not positive who the official contact is	yes ?	Restrictive	no	yes	\N	\N	\N
220	calrw	High	\N	\N	Yang	Yang Zhang	yangzhanglab@umich.edu	Jian Zhang	jianzha@umich.edu	\N	\N	\N	http://zhanglab.ccmb.med.umich.edu/RW/	yes	http://www.ncbi.nlm.nih.gov/pubmed/21060880	\N	\N	yes	1	\N	no	Not found - no registration	?	yes	\N	\N	\N
221	virtualspectrum	\N	\N	\N	Jakob	Jakob Toudahl Nielsen	jtn@chem.au.dk	\N	\N	\N	\N	Peaklist simulation	\N	\N	http://link.springer.com/article/10.1007/s10858-014-9851-1	\N	\N	\N	\N	\N	no	\N	\N	\N	\N	\N	\N
222	calrwplus	High	\N	\N	Yang	Yang Zhang	yangzhanglab@umich.edu	Jian Zhang	jianzha@umich.edu	\N	\N	\N	http://zhanglab.ccmb.med.umich.edu/RW/	same as calrw	http://www.ncbi.nlm.nih.gov/pubmed/21060880	\N	\N	yes	1	\N	\N	Not found - no registration	?	yes	\N	\N	\N
223	atsas	High	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	http://www.embl-hamburg.de/biosaxs/software.html	yes	http://www.ncbi.nlm.nih.gov/pubmed/25484842	\N	\N	yes	2001/02/07	\N	In install directory	Restrictive	no	\N	\N	\N	\N
224	VW_fit	\N	\N	\N	Ad	Ad Bax	bax@nih.gov	Alexander Grishaev	alexanderg@intra.niddk.nih.gov	\N	\N	RDC	http://spin.niddk.nih.gov/bax/software/	\N	http://pubs.acs.org/doi/abs/10.1021/ja4132642	\N	\N	\N	\N	\N	http://spin.niddk.nih.gov/bax/terms.html	Bax-website	no	yes	Done, but official doc coming	Optimization of weights of individual structural models in structural ensemble to achieve best fit for RDCs in multiple alignment media	\N
225	mosart	High	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	https://simtk.org/home/mosart	yes	http://pubs.acs.org/doi/abs/10.1021/ja00085a080	http://link.springer.com/article/10.1007%2FBF02192843#page-1	\N	\N	\N	\N	\N	Not found - no registration	\N	\N	\N	\N	\N
226	nmrview	High	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	yes (no pdf, $)	http://link.springer.com/article/10.1007/BF00404272	\N	\N	\N	\N	\N	\N	nmrviewj	\N	\N	\N	\N	\N
227	xrambo	Old	yes	\N	Jim	James Prestegard	jpresteg@ccrc.uga.edu	\N	\N	\N	\N	\N	http://tesla.ccrc.uga.edu/software/	\N	http://www.ncbi.nlm.nih.gov/pubmed/10968959	\N	\N	\N	\N	\N	http://tesla.ccrc.uga.edu/software/XRAMBO/orig/andrec/copyright.html	academic free - no registration	\N	\N	\N	\N	\N
228	pymol	High	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	https://www.pymol.org/	yes (no pdf, no pub)	http://pymol.org/sites/default/files/pymol.bib	\N	\N	yes	1.7.2.1	\N	yes ?	open source	\N	\N	\N	A molecular visualization system on an open source foundation, maintained and distributed by Schrödinger.	\N
229	Zyggregator (WEB)	\N	\N	\N	Michele	Michele Vendruscolo	mv245@cam.ac.uk	\N	\N	\N	\N	Chemical shift prediction	http://www-mvsoftware.ch.cam.ac.uk/index.php/zyggregator	\N	\N	\N	\N	\N	\N	\N	yes	\N	\N	\N	\N	\N	\N
230	δ2D	\N	\N	\N	Michele	Michele Vendruscolo	mv245@cam.ac.uk	\N	\N	\N	\N	Chemical shift prediction	http://www-mvsoftware.ch.cam.ac.uk/index.php/d2D	\N	\N	\N	\N	\N	\N	\N	yes	GNU GPL	yes	yes	\N	A method of calculating secondary structures populations of proteins from their chemical shifts.	\N
\.


--
-- Name: spreadsheet_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gweatherby
--

SELECT pg_catalog.setval(\'spreadsheet_id_seq\', 230, true);


--
-- Data for Name: survey; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY survey (comments, desired_software_packages, id, nmr_imaging, nmr_other, nmr_solid_state, nmr_solution, persons_id, study_computational, study_dna, study_dynamics, study_metabolomics, study_other, study_proteins, study_rna, study_small_molecules) FROM stdin;
\.


--
-- Data for Name: svn_document_software; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY svn_document_software (software_id, svn_document_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: svn_documents; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY svn_documents (id, type, display, bdata) FROM stdin;
\.


--
-- Name: svn_documents_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'svn_documents_id_seq\', 1, false);


--
-- Data for Name: taggable_taggables; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY taggable_taggables (tag_id, taggable_id, taggable_type, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: taggable_tags; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY taggable_tags (tag_id, name, normalized, created_at, updated_at) FROM stdin;
\.


--
-- Name: taggable_tags_tag_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'taggable_tags_tag_id_seq\', 1, false);


--
-- Data for Name: tags; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY tags (id, keyword) FROM stdin;
\.


--
-- Name: tags_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'tags_id_seq\', 1, false);


--
-- Data for Name: throttle; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY throttle (id, user_id, type, ip, created_at, updated_at) FROM stdin;
1	\N	global	\N	2016-04-04 16:53:34	2016-04-04 16:53:34
2	\N	ip	10.91.27.87	2016-04-04 16:53:34	2016-04-04 16:53:34
3	\N	global	\N	2016-04-04 16:53:37	2016-04-04 16:53:37
4	\N	ip	10.91.27.87	2016-04-04 16:53:37	2016-04-04 16:53:37
5	\N	global	\N	2016-04-04 16:53:43	2016-04-04 16:53:43
6	\N	ip	10.91.27.87	2016-04-04 16:53:43	2016-04-04 16:53:43
7	\N	global	\N	2016-04-05 00:54:56	2016-04-05 00:54:56
8	\N	ip	71.235.54.64	2016-04-05 00:54:56	2016-04-05 00:54:56
9	\N	global	\N	2016-04-05 00:55:29	2016-04-05 00:55:29
10	\N	ip	71.235.54.64	2016-04-05 00:55:29	2016-04-05 00:55:29
11	\N	global	\N	2016-04-05 00:56:38	2016-04-05 00:56:38
12	\N	ip	71.235.54.64	2016-04-05 00:56:38	2016-04-05 00:56:38
13	\N	global	\N	2016-04-05 01:08:16	2016-04-05 01:08:16
14	\N	ip	71.235.54.64	2016-04-05 01:08:16	2016-04-05 01:08:16
15	\N	global	\N	2016-04-05 01:50:44	2016-04-05 01:50:44
16	\N	ip	71.235.54.64	2016-04-05 01:50:44	2016-04-05 01:50:44
17	\N	global	\N	2016-04-05 02:54:48	2016-04-05 02:54:48
18	\N	ip	166.170.35.214	2016-04-05 02:54:48	2016-04-05 02:54:48
19	\N	global	\N	2016-04-05 02:55:00	2016-04-05 02:55:00
20	\N	ip	166.170.35.214	2016-04-05 02:55:00	2016-04-05 02:55:00
21	\N	global	\N	2016-04-05 03:33:06	2016-04-05 03:33:06
22	\N	ip	166.170.35.214	2016-04-05 03:33:06	2016-04-05 03:33:06
23	\N	global	\N	2016-04-05 03:54:59	2016-04-05 03:54:59
24	\N	ip	166.170.35.214	2016-04-05 03:54:59	2016-04-05 03:54:59
25	\N	global	\N	2016-04-05 04:02:06	2016-04-05 04:02:06
26	\N	ip	166.170.35.214	2016-04-05 04:02:06	2016-04-05 04:02:06
\.


--
-- Name: throttle_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'throttle_id_seq\', 26, true);


--
-- Data for Name: timezones; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY timezones (id, zone) FROM stdin;
1	Africa/Abidjan
2	Africa/Accra
3	Africa/Addis_Ababa
4	Africa/Algiers
5	Africa/Asmara
6	Africa/Asmera
7	Africa/Bamako
8	Africa/Bangui
9	Africa/Banjul
10	Africa/Bissau
11	Africa/Blantyre
12	Africa/Brazzaville
13	Africa/Bujumbura
14	Africa/Cairo
15	Africa/Casablanca
16	Africa/Ceuta
17	Africa/Conakry
18	Africa/Dakar
19	Africa/Dar_es_Salaam
20	Africa/Djibouti
21	Africa/Douala
22	Africa/El_Aaiun
23	Africa/Freetown
24	Africa/Gaborone
25	Africa/Harare
26	Africa/Johannesburg
27	Africa/Juba
28	Africa/Kampala
29	Africa/Khartoum
30	Africa/Kigali
31	Africa/Kinshasa
32	Africa/Lagos
33	Africa/Libreville
34	Africa/Lome
35	Africa/Luanda
36	Africa/Lubumbashi
37	Africa/Lusaka
38	Africa/Malabo
39	Africa/Maputo
40	Africa/Maseru
41	Africa/Mbabane
42	Africa/Mogadishu
43	Africa/Monrovia
44	Africa/Nairobi
45	Africa/Ndjamena
46	Africa/Niamey
47	Africa/Nouakchott
48	Africa/Ouagadougou
49	Africa/Porto-Novo
50	Africa/Sao_Tome
51	Africa/Timbuktu
52	Africa/Tripoli
53	Africa/Tunis
54	Africa/Windhoek
55	America/Adak
56	America/Anchorage
57	America/Anguilla
58	America/Antigua
59	America/Araguaina
60	America/Argentina/Buenos_Aires
61	America/Argentina/Catamarca
62	America/Argentina/ComodRivadavia
63	America/Argentina/Cordoba
64	America/Argentina/Jujuy
65	America/Argentina/La_Rioja
66	America/Argentina/Mendoza
67	America/Argentina/Rio_Gallegos
68	America/Argentina/Salta
69	America/Argentina/San_Juan
70	America/Argentina/San_Luis
71	America/Argentina/Tucuman
72	America/Argentina/Ushuaia
73	America/Aruba
74	America/Asuncion
75	America/Atikokan
76	America/Atka
77	America/Bahia
78	America/Bahia_Banderas
79	America/Barbados
80	America/Belem
81	America/Belize
82	America/Blanc-Sablon
83	America/Boa_Vista
84	America/Bogota
85	America/Boise
86	America/Buenos_Aires
87	America/Cambridge_Bay
88	America/Campo_Grande
89	America/Cancun
90	America/Caracas
91	America/Catamarca
92	America/Cayenne
93	America/Cayman
94	America/Chicago
95	America/Chihuahua
96	America/Coral_Harbour
97	America/Cordoba
98	America/Costa_Rica
99	America/Creston
100	America/Cuiaba
101	America/Curacao
102	America/Danmarkshavn
103	America/Dawson
104	America/Dawson_Creek
105	America/Denver
106	America/Detroit
107	America/Dominica
108	America/Edmonton
109	America/Eirunepe
110	America/El_Salvador
111	America/Ensenada
112	America/Fortaleza
113	America/Fort_Nelson
114	America/Fort_Wayne
115	America/Glace_Bay
116	America/Godthab
117	America/Goose_Bay
118	America/Grand_Turk
119	America/Grenada
120	America/Guadeloupe
121	America/Guatemala
122	America/Guayaquil
123	America/Guyana
124	America/Halifax
125	America/Havana
126	America/Hermosillo
127	America/Indiana/Indianapolis
128	America/Indiana/Knox
129	America/Indiana/Marengo
130	America/Indiana/Petersburg
131	America/Indianapolis
132	America/Indiana/Tell_City
133	America/Indiana/Vevay
134	America/Indiana/Vincennes
135	America/Indiana/Winamac
136	America/Inuvik
137	America/Iqaluit
138	America/Jamaica
139	America/Jujuy
140	America/Juneau
141	America/Kentucky/Louisville
142	America/Kentucky/Monticello
143	America/Knox_IN
144	America/Kralendijk
145	America/La_Paz
146	America/Lima
147	America/Los_Angeles
148	America/Louisville
149	America/Lower_Princes
150	America/Maceio
151	America/Managua
152	America/Manaus
153	America/Marigot
154	America/Martinique
155	America/Matamoros
156	America/Mazatlan
157	America/Mendoza
158	America/Menominee
159	America/Merida
160	America/Metlakatla
161	America/Mexico_City
162	America/Miquelon
163	America/Moncton
164	America/Monterrey
165	America/Montevideo
166	America/Montreal
167	America/Montserrat
168	America/Nassau
169	America/New_York
170	America/Nipigon
171	America/Nome
172	America/Noronha
173	America/North_Dakota/Beulah
174	America/North_Dakota/Center
175	America/North_Dakota/New_Salem
176	America/Ojinaga
177	America/Panama
178	America/Pangnirtung
179	America/Paramaribo
180	America/Phoenix
181	America/Port-au-Prince
182	America/Porto_Acre
183	America/Port_of_Spain
184	America/Porto_Velho
185	America/Puerto_Rico
186	America/Rainy_River
187	America/Rankin_Inlet
188	America/Recife
189	America/Regina
190	America/Resolute
191	America/Rio_Branco
192	America/Rosario
193	America/Santa_Isabel
194	America/Santarem
195	America/Santiago
196	America/Santo_Domingo
197	America/Sao_Paulo
198	America/Scoresbysund
199	America/Shiprock
200	America/Sitka
201	America/St_Barthelemy
202	America/St_Johns
203	America/St_Kitts
204	America/St_Lucia
205	America/St_Thomas
206	America/St_Vincent
207	America/Swift_Current
208	America/Tegucigalpa
209	America/Thule
210	America/Thunder_Bay
211	America/Tijuana
212	America/Toronto
213	America/Tortola
214	America/Vancouver
215	America/Virgin
216	America/Whitehorse
217	America/Winnipeg
218	America/Yakutat
219	America/Yellowknife
220	Antarctica/Casey
221	Antarctica/Davis
222	Antarctica/DumontDUrville
223	Antarctica/Macquarie
224	Antarctica/Mawson
225	Antarctica/McMurdo
226	Antarctica/Palmer
227	Antarctica/Rothera
228	Antarctica/South_Pole
229	Antarctica/Syowa
230	Antarctica/Troll
231	Antarctica/Vostok
232	Arctic/Longyearbyen
233	Asia/Aden
234	Asia/Almaty
235	Asia/Amman
236	Asia/Anadyr
237	Asia/Aqtau
238	Asia/Aqtobe
239	Asia/Ashgabat
240	Asia/Ashkhabad
241	Asia/Baghdad
242	Asia/Bahrain
243	Asia/Baku
244	Asia/Bangkok
245	Asia/Beirut
246	Asia/Bishkek
247	Asia/Brunei
248	Asia/Calcutta
249	Asia/Chita
250	Asia/Choibalsan
251	Asia/Chongqing
252	Asia/Chungking
253	Asia/Colombo
254	Asia/Dacca
255	Asia/Damascus
256	Asia/Dhaka
257	Asia/Dili
258	Asia/Dubai
259	Asia/Dushanbe
260	Asia/Gaza
261	Asia/Harbin
262	Asia/Hebron
263	Asia/Ho_Chi_Minh
264	Asia/Hong_Kong
265	Asia/Hovd
266	Asia/Irkutsk
267	Asia/Istanbul
268	Asia/Jakarta
269	Asia/Jayapura
270	Asia/Jerusalem
271	Asia/Kabul
272	Asia/Kamchatka
273	Asia/Karachi
274	Asia/Kashgar
275	Asia/Kathmandu
276	Asia/Katmandu
277	Asia/Khandyga
278	Asia/Kolkata
279	Asia/Krasnoyarsk
280	Asia/Kuala_Lumpur
281	Asia/Kuching
282	Asia/Kuwait
283	Asia/Macao
284	Asia/Macau
285	Asia/Magadan
286	Asia/Makassar
287	Asia/Manila
288	Asia/Muscat
289	Asia/Nicosia
290	Asia/Novokuznetsk
291	Asia/Novosibirsk
292	Asia/Omsk
293	Asia/Oral
294	Asia/Phnom_Penh
295	Asia/Pontianak
296	Asia/Pyongyang
297	Asia/Qatar
298	Asia/Qyzylorda
299	Asia/Rangoon
300	Asia/Riyadh
301	Asia/Saigon
302	Asia/Sakhalin
303	Asia/Samarkand
304	Asia/Seoul
305	Asia/Shanghai
306	Asia/Singapore
307	Asia/Srednekolymsk
308	Asia/Taipei
309	Asia/Tashkent
310	Asia/Tbilisi
311	Asia/Tehran
312	Asia/Tel_Aviv
313	Asia/Thimbu
314	Asia/Thimphu
315	Asia/Tokyo
316	Asia/Ujung_Pandang
317	Asia/Ulaanbaatar
318	Asia/Ulan_Bator
319	Asia/Urumqi
320	Asia/Ust-Nera
321	Asia/Vientiane
322	Asia/Vladivostok
323	Asia/Yakutsk
324	Asia/Yekaterinburg
325	Asia/Yerevan
326	Atlantic/Azores
327	Atlantic/Bermuda
328	Atlantic/Canary
329	Atlantic/Cape_Verde
330	Atlantic/Faeroe
331	Atlantic/Faroe
332	Atlantic/Jan_Mayen
333	Atlantic/Madeira
334	Atlantic/Reykjavik
335	Atlantic/South_Georgia
336	Atlantic/Stanley
337	Atlantic/St_Helena
338	Australia/ACT
339	Australia/Adelaide
340	Australia/Brisbane
341	Australia/Broken_Hill
342	Australia/Canberra
343	Australia/Currie
344	Australia/Darwin
345	Australia/Eucla
346	Australia/Hobart
347	Australia/LHI
348	Australia/Lindeman
349	Australia/Lord_Howe
350	Australia/Melbourne
351	Australia/North
352	Australia/NSW
353	Australia/Perth
354	Australia/Queensland
355	Australia/South
356	Australia/Sydney
357	Australia/Tasmania
358	Australia/Victoria
359	Australia/West
360	Australia/Yancowinna
361	Europe/Amsterdam
362	Europe/Andorra
363	Europe/Athens
364	Europe/Belfast
365	Europe/Belgrade
366	Europe/Berlin
367	Europe/Bratislava
368	Europe/Brussels
369	Europe/Bucharest
370	Europe/Budapest
371	Europe/Busingen
372	Europe/Chisinau
373	Europe/Copenhagen
374	Europe/Dublin
375	Europe/Gibraltar
376	Europe/Guernsey
377	Europe/Helsinki
378	Europe/Isle_of_Man
379	Europe/Istanbul
380	Europe/Jersey
381	Europe/Kaliningrad
382	Europe/Kiev
383	Europe/Lisbon
384	Europe/Ljubljana
385	Europe/London
386	Europe/Luxembourg
387	Europe/Madrid
388	Europe/Malta
389	Europe/Mariehamn
390	Europe/Minsk
391	Europe/Monaco
392	Europe/Moscow
393	Europe/Nicosia
394	Europe/Oslo
395	Europe/Paris
396	Europe/Podgorica
397	Europe/Prague
398	Europe/Riga
399	Europe/Rome
400	Europe/Samara
401	Europe/San_Marino
402	Europe/Sarajevo
403	Europe/Simferopol
404	Europe/Skopje
405	Europe/Sofia
406	Europe/Stockholm
407	Europe/Tallinn
408	Europe/Tirane
409	Europe/Tiraspol
410	Europe/Uzhgorod
411	Europe/Vaduz
412	Europe/Vatican
413	Europe/Vienna
414	Europe/Vilnius
415	Europe/Volgograd
416	Europe/Warsaw
417	Europe/Zagreb
418	Europe/Zaporozhye
419	Europe/Zurich
420	Indian/Antananarivo
421	Indian/Chagos
422	Indian/Christmas
423	Indian/Cocos
424	Indian/Comoro
425	Indian/Kerguelen
426	Indian/Mahe
427	Indian/Maldives
428	Indian/Mauritius
429	Indian/Mayotte
430	Indian/Reunion
431	Pacific/Apia
432	Pacific/Auckland
433	Pacific/Bougainville
434	Pacific/Chatham
435	Pacific/Chuuk
436	Pacific/Easter
437	Pacific/Efate
438	Pacific/Enderbury
439	Pacific/Fakaofo
440	Pacific/Fiji
441	Pacific/Funafuti
442	Pacific/Galapagos
443	Pacific/Gambier
444	Pacific/Guadalcanal
445	Pacific/Guam
446	Pacific/Honolulu
447	Pacific/Johnston
448	Pacific/Kiritimati
449	Pacific/Kosrae
450	Pacific/Kwajalein
451	Pacific/Majuro
452	Pacific/Marquesas
453	Pacific/Midway
454	Pacific/Nauru
455	Pacific/Niue
456	Pacific/Norfolk
457	Pacific/Noumea
458	Pacific/Pago_Pago
459	Pacific/Palau
460	Pacific/Pitcairn
461	Pacific/Pohnpei
462	Pacific/Ponape
463	Pacific/Port_Moresby
464	Pacific/Rarotonga
465	Pacific/Saipan
466	Pacific/Samoa
467	Pacific/Tahiti
468	Pacific/Tarawa
469	Pacific/Tongatapu
470	Pacific/Truk
471	Pacific/Wake
472	Pacific/Wallis
473	Pacific/Yap
\.


--
-- Name: timezones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'timezones_id_seq\', 946, true);


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY users (id, password, permissions, last_login, created_at, updated_at, deleted_at, person_id) FROM stdin;
1	$2y$10$jOHX5gOjDbOIjuNf/2e02Omjcmv5hSmgZPAqbuIrIK3zKC/NNjQI2	\N	2016-04-06 12:01:24	2016-04-03 02:25:06	2016-04-06 12:01:24	\N	1
\.


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'users_id_seq\', 1, true);


--
-- Data for Name: vms; Type: TABLE DATA; Schema: public; Owner: laravel
--

COPY vms (id, name, major, minor, variant) FROM stdin;
\.


--
-- Name: vms_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
--

SELECT pg_catalog.setval(\'vms_id_seq\', 1, false);


--
-- Name: activations_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY activations
    ADD CONSTRAINT activations_pkey PRIMARY KEY (id);


--
-- Name: blog_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY blog_categories
    ADD CONSTRAINT blog_categories_pkey PRIMARY KEY (id);


--
-- Name: blog_comments_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY blog_comments
    ADD CONSTRAINT blog_comments_pkey PRIMARY KEY (id);


--
-- Name: blogs_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY blogs
    ADD CONSTRAINT blogs_pkey PRIMARY KEY (id);


--
-- Name: citation_person_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY citation_person
    ADD CONSTRAINT citation_person_pkey PRIMARY KEY (person_id, citation_id);


--
-- Name: citation_software_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY citation_software
    ADD CONSTRAINT citation_software_pkey PRIMARY KEY (software_id, citation_id);


--
-- Name: citation_types_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY citation_types
    ADD CONSTRAINT citation_types_pkey PRIMARY KEY (id);


--
-- Name: citations_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY citations
    ADD CONSTRAINT citations_pkey PRIMARY KEY (id);


--
-- Name: files_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY files
    ADD CONSTRAINT files_pkey PRIMARY KEY (id);


--
-- Name: files_slug_unique; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY files
    ADD CONSTRAINT files_slug_unique UNIQUE (slug);


--
-- Name: instiutions_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY institutions
    ADD CONSTRAINT instiutions_pkey PRIMARY KEY (id);


--
-- Name: lab_person_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY lab_person
    ADD CONSTRAINT lab_person_pkey PRIMARY KEY (person_id, lab_id);


--
-- Name: lab_role_person_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY lab_role_person
    ADD CONSTRAINT lab_role_person_pkey PRIMARY KEY (person_id, lab_role_id, software_id);


--
-- Name: lab_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY lab_roles
    ADD CONSTRAINT lab_roles_pkey PRIMARY KEY (id);


--
-- Name: lab_software_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY lab_software
    ADD CONSTRAINT lab_software_pkey PRIMARY KEY (software_id, lab_id);


--
-- Name: labs_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY labs
    ADD CONSTRAINT labs_pkey PRIMARY KEY (id);


--
-- Name: menu_software_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY menu_software
    ADD CONSTRAINT menu_software_pkey PRIMARY KEY (software_id, menu_id);


--
-- Name: menus_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY menus
    ADD CONSTRAINT menus_pkey PRIMARY KEY (id);


--
-- Name: pages_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY pages
    ADD CONSTRAINT pages_pkey PRIMARY KEY (id);


--
-- Name: persistences_code_unique; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY persistences
    ADD CONSTRAINT persistences_code_unique UNIQUE (code);


--
-- Name: persistences_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY persistences
    ADD CONSTRAINT persistences_pkey PRIMARY KEY (id);


--
-- Name: person_software_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY person_software
    ADD CONSTRAINT person_software_pkey PRIMARY KEY (person_id, software_id);


--
-- Name: persons_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY persons
    ADD CONSTRAINT persons_pkey PRIMARY KEY (id);


--
-- Name: pksurvey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY survey
    ADD CONSTRAINT pksurvey PRIMARY KEY (id);


--
-- Name: reminders_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY reminders
    ADD CONSTRAINT reminders_pkey PRIMARY KEY (id);


--
-- Name: role_users_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY role_users
    ADD CONSTRAINT role_users_pkey PRIMARY KEY (user_id, role_id);


--
-- Name: roles_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: roles_slug_unique; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY roles
    ADD CONSTRAINT roles_slug_unique UNIQUE (slug);


--
-- Name: software_name_unique; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY software
    ADD CONSTRAINT software_name_unique UNIQUE (name);


--
-- Name: software_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY software
    ADD CONSTRAINT software_pkey PRIMARY KEY (id);


--
-- Name: software_short_title_unique; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY software
    ADD CONSTRAINT software_short_title_unique UNIQUE (short_title);


--
-- Name: software_tag_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY software_tag
    ADD CONSTRAINT software_tag_pkey PRIMARY KEY (software_id, tag_id);


--
-- Name: software_version_vm_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY software_version_vm
    ADD CONSTRAINT software_version_vm_pkey PRIMARY KEY (software_version_id, vm_id);


--
-- Name: software_versions_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY software_versions
    ADD CONSTRAINT software_versions_pkey PRIMARY KEY (id);


--
-- Name: software_versions_software_id_version_unique; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY software_versions
    ADD CONSTRAINT software_versions_software_id_version_unique UNIQUE (software_id, version);


--
-- Name: spreadsheet_pky; Type: CONSTRAINT; Schema: public; Owner: gweatherby; Tablespace: 
--

ALTER TABLE ONLY spreadsheet
    ADD CONSTRAINT spreadsheet_pky PRIMARY KEY (id);


--
-- Name: svn_document_software_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY svn_document_software
    ADD CONSTRAINT svn_document_software_pkey PRIMARY KEY (software_id, svn_document_id);


--
-- Name: svn_documents_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY svn_documents
    ADD CONSTRAINT svn_documents_pkey PRIMARY KEY (id);


--
-- Name: taggable_tags_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY taggable_tags
    ADD CONSTRAINT taggable_tags_pkey PRIMARY KEY (tag_id);


--
-- Name: tags_keyword_unique; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY tags
    ADD CONSTRAINT tags_keyword_unique UNIQUE (keyword);


--
-- Name: tags_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY tags
    ADD CONSTRAINT tags_pkey PRIMARY KEY (id);


--
-- Name: throttle_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY throttle
    ADD CONSTRAINT throttle_pkey PRIMARY KEY (id);


--
-- Name: timezones_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY timezones
    ADD CONSTRAINT timezones_pkey PRIMARY KEY (id);


--
-- Name: timezones_zone_key; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY timezones
    ADD CONSTRAINT timezones_zone_key UNIQUE (zone);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: vms_major_minor_unique; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY vms
    ADD CONSTRAINT vms_major_minor_unique UNIQUE (major, minor);


--
-- Name: vms_pkey; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
--

ALTER TABLE ONLY vms
    ADD CONSTRAINT vms_pkey PRIMARY KEY (id);


--
-- Name: taggable_taggables_taggable_id_index; Type: INDEX; Schema: public; Owner: laravel; Tablespace: 
--

CREATE INDEX taggable_taggables_taggable_id_index ON taggable_taggables USING btree (taggable_id);


--
-- Name: throttle_user_id_index; Type: INDEX; Schema: public; Owner: laravel; Tablespace: 
--

CREATE INDEX throttle_user_id_index ON throttle USING btree (user_id);


--
-- Name: software_name_upper_trigger; Type: TRIGGER; Schema: public; Owner: laravel
--

CREATE TRIGGER software_name_upper_trigger BEFORE INSERT OR UPDATE ON software FOR EACH ROW EXECUTE PROCEDURE software_name_upper();


--
-- Name: citation_person_citation_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY citation_person
    ADD CONSTRAINT citation_person_citation_id_foreign FOREIGN KEY (citation_id) REFERENCES citations(id) ON DELETE CASCADE;


--
-- Name: citation_person_person_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY citation_person
    ADD CONSTRAINT citation_person_person_id_foreign FOREIGN KEY (person_id) REFERENCES persons(id) ON DELETE CASCADE;


--
-- Name: citation_software_citation_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY citation_software
    ADD CONSTRAINT citation_software_citation_id_foreign FOREIGN KEY (citation_id) REFERENCES citations(id) ON DELETE CASCADE;


--
-- Name: citation_software_software_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY citation_software
    ADD CONSTRAINT citation_software_software_id_foreign FOREIGN KEY (software_id) REFERENCES software(id) ON DELETE CASCADE;


--
-- Name: citations_citation_type_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY citations
    ADD CONSTRAINT citations_citation_type_id_foreign FOREIGN KEY (citation_type_id) REFERENCES citation_types(id) ON DELETE CASCADE;


--
-- Name: files_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY files
    ADD CONSTRAINT files_role_id_foreign FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE;


--
-- Name: files_software_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY files
    ADD CONSTRAINT files_software_id_foreign FOREIGN KEY (software_id) REFERENCES software(id) ON DELETE CASCADE;


--
-- Name: files_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY files
    ADD CONSTRAINT files_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;


--
-- Name: fk_survey_persons; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY survey
    ADD CONSTRAINT fk_survey_persons FOREIGN KEY (persons_id) REFERENCES persons(id);


--
-- Name: lab_person_lab_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY lab_person
    ADD CONSTRAINT lab_person_lab_id_foreign FOREIGN KEY (lab_id) REFERENCES labs(id) ON DELETE CASCADE;


--
-- Name: lab_person_person_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY lab_person
    ADD CONSTRAINT lab_person_person_id_foreign FOREIGN KEY (person_id) REFERENCES persons(id) ON DELETE CASCADE;


--
-- Name: lab_role_person_lab_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY lab_role_person
    ADD CONSTRAINT lab_role_person_lab_role_id_foreign FOREIGN KEY (lab_role_id) REFERENCES lab_roles(id) ON DELETE CASCADE;


--
-- Name: lab_role_person_person_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY lab_role_person
    ADD CONSTRAINT lab_role_person_person_id_foreign FOREIGN KEY (person_id) REFERENCES persons(id) ON DELETE CASCADE;


--
-- Name: lab_role_person_software_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY lab_role_person
    ADD CONSTRAINT lab_role_person_software_id_foreign FOREIGN KEY (software_id) REFERENCES software(id) ON DELETE CASCADE;


--
-- Name: lab_software_lab_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY lab_software
    ADD CONSTRAINT lab_software_lab_id_foreign FOREIGN KEY (lab_id) REFERENCES labs(id) ON DELETE CASCADE;


--
-- Name: lab_software_software_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY lab_software
    ADD CONSTRAINT lab_software_software_id_foreign FOREIGN KEY (software_id) REFERENCES software(id) ON DELETE CASCADE;


--
-- Name: menu_software_menu_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY menu_software
    ADD CONSTRAINT menu_software_menu_id_foreign FOREIGN KEY (menu_id) REFERENCES menus(id) ON DELETE CASCADE;


--
-- Name: menu_software_software_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY menu_software
    ADD CONSTRAINT menu_software_software_id_foreign FOREIGN KEY (software_id) REFERENCES software(id) ON DELETE CASCADE;


--
-- Name: person_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY users
    ADD CONSTRAINT person_id_fkey FOREIGN KEY (person_id) REFERENCES persons(id);


--
-- Name: person_software_person_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY person_software
    ADD CONSTRAINT person_software_person_id_foreign FOREIGN KEY (person_id) REFERENCES persons(id) ON DELETE CASCADE;


--
-- Name: person_software_software_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY person_software
    ADD CONSTRAINT person_software_software_id_foreign FOREIGN KEY (software_id) REFERENCES software(id) ON DELETE CASCADE;


--
-- Name: persons_institution_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY persons
    ADD CONSTRAINT persons_institution_id_fkey FOREIGN KEY (institution_id) REFERENCES institutions(id);


--
-- Name: persons_time_zone_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY persons
    ADD CONSTRAINT persons_time_zone_id_fkey FOREIGN KEY (time_zone_id) REFERENCES timezones(id);


--
-- Name: role_users_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY role_users
    ADD CONSTRAINT role_users_role_id_foreign FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE;


--
-- Name: role_users_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY role_users
    ADD CONSTRAINT role_users_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;


--
-- Name: software_persons__fk; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY software
    ADD CONSTRAINT software_persons__fk FOREIGN KEY (contact_id) REFERENCES persons(id);


--
-- Name: software_tag_software_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY software_tag
    ADD CONSTRAINT software_tag_software_id_foreign FOREIGN KEY (software_id) REFERENCES software(id) ON DELETE CASCADE;


--
-- Name: software_tag_tag_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY software_tag
    ADD CONSTRAINT software_tag_tag_id_foreign FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE;


--
-- Name: software_version_vm_software_version_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY software_version_vm
    ADD CONSTRAINT software_version_vm_software_version_id_foreign FOREIGN KEY (software_version_id) REFERENCES software_versions(id) ON DELETE CASCADE;


--
-- Name: software_version_vm_vm_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY software_version_vm
    ADD CONSTRAINT software_version_vm_vm_id_foreign FOREIGN KEY (vm_id) REFERENCES vms(id) ON DELETE CASCADE;


--
-- Name: software_versions_software_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY software_versions
    ADD CONSTRAINT software_versions_software_id_foreign FOREIGN KEY (software_id) REFERENCES software(id) ON DELETE CASCADE;


--
-- Name: svn_document_software_software_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY svn_document_software
    ADD CONSTRAINT svn_document_software_software_id_foreign FOREIGN KEY (software_id) REFERENCES software(id) ON DELETE CASCADE;


--
-- Name: svn_document_software_svn_document_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: laravel
--

ALTER TABLE ONLY svn_document_software
    ADD CONSTRAINT svn_document_software_svn_document_id_foreign FOREIGN KEY (svn_document_id) REFERENCES svn_documents(id) ON DELETE CASCADE;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- Name: activations; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE activations FROM PUBLIC;
REVOKE ALL ON TABLE activations FROM laravel;
GRANT ALL ON TABLE activations TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE activations TO nmrbox;


--
-- Name: activations_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE activations_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE activations_id_seq FROM laravel;
GRANT ALL ON SEQUENCE activations_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE activations_id_seq TO nmrbox;


--
-- Name: blog_categories; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE blog_categories FROM PUBLIC;
REVOKE ALL ON TABLE blog_categories FROM laravel;
GRANT ALL ON TABLE blog_categories TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE blog_categories TO nmrbox;


--
-- Name: blog_categories_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE blog_categories_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE blog_categories_id_seq FROM laravel;
GRANT ALL ON SEQUENCE blog_categories_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE blog_categories_id_seq TO nmrbox;


--
-- Name: blog_comments; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE blog_comments FROM PUBLIC;
REVOKE ALL ON TABLE blog_comments FROM laravel;
GRANT ALL ON TABLE blog_comments TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE blog_comments TO nmrbox;


--
-- Name: blog_comments_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE blog_comments_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE blog_comments_id_seq FROM laravel;
GRANT ALL ON SEQUENCE blog_comments_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE blog_comments_id_seq TO nmrbox;


--
-- Name: blogs; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE blogs FROM PUBLIC;
REVOKE ALL ON TABLE blogs FROM laravel;
GRANT ALL ON TABLE blogs TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE blogs TO nmrbox;


--
-- Name: blogs_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE blogs_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE blogs_id_seq FROM laravel;
GRANT ALL ON SEQUENCE blogs_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE blogs_id_seq TO nmrbox;


--
-- Name: citation_person; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE citation_person FROM PUBLIC;
REVOKE ALL ON TABLE citation_person FROM laravel;
GRANT ALL ON TABLE citation_person TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE citation_person TO nmrbox;


--
-- Name: citation_software; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE citation_software FROM PUBLIC;
REVOKE ALL ON TABLE citation_software FROM laravel;
GRANT ALL ON TABLE citation_software TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE citation_software TO nmrbox;


--
-- Name: citation_types; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE citation_types FROM PUBLIC;
REVOKE ALL ON TABLE citation_types FROM laravel;
GRANT ALL ON TABLE citation_types TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE citation_types TO nmrbox;


--
-- Name: citation_types_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE citation_types_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE citation_types_id_seq FROM laravel;
GRANT ALL ON SEQUENCE citation_types_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE citation_types_id_seq TO nmrbox;


--
-- Name: citations; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE citations FROM PUBLIC;
REVOKE ALL ON TABLE citations FROM laravel;
GRANT ALL ON TABLE citations TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE citations TO nmrbox;


--
-- Name: citations_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE citations_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE citations_id_seq FROM laravel;
GRANT ALL ON SEQUENCE citations_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE citations_id_seq TO nmrbox;


--
-- Name: files; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE files FROM PUBLIC;
REVOKE ALL ON TABLE files FROM laravel;
GRANT ALL ON TABLE files TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE files TO nmrbox;


--
-- Name: files_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE files_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE files_id_seq FROM laravel;
GRANT ALL ON SEQUENCE files_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE files_id_seq TO nmrbox;


--
-- Name: lab_person; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE lab_person FROM PUBLIC;
REVOKE ALL ON TABLE lab_person FROM laravel;
GRANT ALL ON TABLE lab_person TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE lab_person TO nmrbox;


--
-- Name: lab_role_person; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE lab_role_person FROM PUBLIC;
REVOKE ALL ON TABLE lab_role_person FROM laravel;
GRANT ALL ON TABLE lab_role_person TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE lab_role_person TO nmrbox;


--
-- Name: lab_roles; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE lab_roles FROM PUBLIC;
REVOKE ALL ON TABLE lab_roles FROM laravel;
GRANT ALL ON TABLE lab_roles TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE lab_roles TO nmrbox;


--
-- Name: lab_roles_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE lab_roles_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE lab_roles_id_seq FROM laravel;
GRANT ALL ON SEQUENCE lab_roles_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE lab_roles_id_seq TO nmrbox;


--
-- Name: lab_software; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE lab_software FROM PUBLIC;
REVOKE ALL ON TABLE lab_software FROM laravel;
GRANT ALL ON TABLE lab_software TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE lab_software TO nmrbox;


--
-- Name: labs; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE labs FROM PUBLIC;
REVOKE ALL ON TABLE labs FROM laravel;
GRANT ALL ON TABLE labs TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE labs TO nmrbox;


--
-- Name: labs_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE labs_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE labs_id_seq FROM laravel;
GRANT ALL ON SEQUENCE labs_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE labs_id_seq TO nmrbox;


--
-- Name: menu_software; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE menu_software FROM PUBLIC;
REVOKE ALL ON TABLE menu_software FROM laravel;
GRANT ALL ON TABLE menu_software TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE menu_software TO nmrbox;


--
-- Name: menus; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE menus FROM PUBLIC;
REVOKE ALL ON TABLE menus FROM laravel;
GRANT ALL ON TABLE menus TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE menus TO nmrbox;


--
-- Name: menus_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE menus_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE menus_id_seq FROM laravel;
GRANT ALL ON SEQUENCE menus_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE menus_id_seq TO nmrbox;


--
-- Name: pages; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE pages FROM PUBLIC;
REVOKE ALL ON TABLE pages FROM laravel;
GRANT ALL ON TABLE pages TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE pages TO nmrbox;


--
-- Name: pages_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE pages_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE pages_id_seq FROM laravel;
GRANT ALL ON SEQUENCE pages_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE pages_id_seq TO nmrbox;


--
-- Name: persistences; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE persistences FROM PUBLIC;
REVOKE ALL ON TABLE persistences FROM laravel;
GRANT ALL ON TABLE persistences TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE persistences TO nmrbox;


--
-- Name: persistences_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE persistences_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE persistences_id_seq FROM laravel;
GRANT ALL ON SEQUENCE persistences_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE persistences_id_seq TO nmrbox;


--
-- Name: person_software; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE person_software FROM PUBLIC;
REVOKE ALL ON TABLE person_software FROM laravel;
GRANT ALL ON TABLE person_software TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE person_software TO nmrbox;


--
-- Name: persons; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE persons FROM PUBLIC;
REVOKE ALL ON TABLE persons FROM laravel;
GRANT ALL ON TABLE persons TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE persons TO nmrbox;


--
-- Name: persons_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE persons_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE persons_id_seq FROM laravel;
GRANT ALL ON SEQUENCE persons_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE persons_id_seq TO nmrbox;


--
-- Name: reminders; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE reminders FROM PUBLIC;
REVOKE ALL ON TABLE reminders FROM laravel;
GRANT ALL ON TABLE reminders TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE reminders TO nmrbox;


--
-- Name: reminders_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE reminders_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE reminders_id_seq FROM laravel;
GRANT ALL ON SEQUENCE reminders_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE reminders_id_seq TO nmrbox;


--
-- Name: role_users; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE role_users FROM PUBLIC;
REVOKE ALL ON TABLE role_users FROM laravel;
GRANT ALL ON TABLE role_users TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE role_users TO nmrbox;


--
-- Name: roles; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE roles FROM PUBLIC;
REVOKE ALL ON TABLE roles FROM laravel;
GRANT ALL ON TABLE roles TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE roles TO nmrbox;


--
-- Name: roles_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE roles_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE roles_id_seq FROM laravel;
GRANT ALL ON SEQUENCE roles_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE roles_id_seq TO nmrbox;


--
-- Name: software; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE software FROM PUBLIC;
REVOKE ALL ON TABLE software FROM laravel;
GRANT ALL ON TABLE software TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE software TO nmrbox;


--
-- Name: software_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE software_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE software_id_seq FROM laravel;
GRANT ALL ON SEQUENCE software_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE software_id_seq TO nmrbox;


--
-- Name: software_tag; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE software_tag FROM PUBLIC;
REVOKE ALL ON TABLE software_tag FROM laravel;
GRANT ALL ON TABLE software_tag TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE software_tag TO nmrbox;


--
-- Name: software_version_vm; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE software_version_vm FROM PUBLIC;
REVOKE ALL ON TABLE software_version_vm FROM laravel;
GRANT ALL ON TABLE software_version_vm TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE software_version_vm TO nmrbox;


--
-- Name: software_versions; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE software_versions FROM PUBLIC;
REVOKE ALL ON TABLE software_versions FROM laravel;
GRANT ALL ON TABLE software_versions TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE software_versions TO nmrbox;


--
-- Name: software_versions_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE software_versions_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE software_versions_id_seq FROM laravel;
GRANT ALL ON SEQUENCE software_versions_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE software_versions_id_seq TO nmrbox;


--
-- Name: svn_document_software; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE svn_document_software FROM PUBLIC;
REVOKE ALL ON TABLE svn_document_software FROM laravel;
GRANT ALL ON TABLE svn_document_software TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE svn_document_software TO nmrbox;


--
-- Name: svn_documents; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE svn_documents FROM PUBLIC;
REVOKE ALL ON TABLE svn_documents FROM laravel;
GRANT ALL ON TABLE svn_documents TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE svn_documents TO nmrbox;


--
-- Name: svn_documents_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE svn_documents_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE svn_documents_id_seq FROM laravel;
GRANT ALL ON SEQUENCE svn_documents_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE svn_documents_id_seq TO nmrbox;


--
-- Name: taggable_taggables; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE taggable_taggables FROM PUBLIC;
REVOKE ALL ON TABLE taggable_taggables FROM laravel;
GRANT ALL ON TABLE taggable_taggables TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE taggable_taggables TO nmrbox;


--
-- Name: taggable_tags; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE taggable_tags FROM PUBLIC;
REVOKE ALL ON TABLE taggable_tags FROM laravel;
GRANT ALL ON TABLE taggable_tags TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE taggable_tags TO nmrbox;


--
-- Name: taggable_tags_tag_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE taggable_tags_tag_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE taggable_tags_tag_id_seq FROM laravel;
GRANT ALL ON SEQUENCE taggable_tags_tag_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE taggable_tags_tag_id_seq TO nmrbox;


--
-- Name: tags; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE tags FROM PUBLIC;
REVOKE ALL ON TABLE tags FROM laravel;
GRANT ALL ON TABLE tags TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE tags TO nmrbox;


--
-- Name: tags_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE tags_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE tags_id_seq FROM laravel;
GRANT ALL ON SEQUENCE tags_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE tags_id_seq TO nmrbox;


--
-- Name: throttle; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE throttle FROM PUBLIC;
REVOKE ALL ON TABLE throttle FROM laravel;
GRANT ALL ON TABLE throttle TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE throttle TO nmrbox;


--
-- Name: throttle_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE throttle_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE throttle_id_seq FROM laravel;
GRANT ALL ON SEQUENCE throttle_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE throttle_id_seq TO nmrbox;


--
-- Name: users; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE users FROM PUBLIC;
REVOKE ALL ON TABLE users FROM laravel;
GRANT ALL ON TABLE users TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE users TO nmrbox;


--
-- Name: users_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE users_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE users_id_seq FROM laravel;
GRANT ALL ON SEQUENCE users_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE users_id_seq TO nmrbox;


--
-- Name: vms; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON TABLE vms FROM PUBLIC;
REVOKE ALL ON TABLE vms FROM laravel;
GRANT ALL ON TABLE vms TO laravel;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE vms TO nmrbox;


--
-- Name: vms_id_seq; Type: ACL; Schema: public; Owner: laravel
--

REVOKE ALL ON SEQUENCE vms_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE vms_id_seq FROM laravel;
GRANT ALL ON SEQUENCE vms_id_seq TO laravel;
GRANT SELECT,UPDATE ON SEQUENCE vms_id_seq TO nmrbox;


--
-- PostgreSQL database dump complete
--


        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('
            drop schema public cascade;
            create schema public;
            
            --- get laravel to shut up about missing migrations
            
            CREATE TABLE migrations
                (
                    migration VARCHAR(255) NOT NULL,
                    batch INTEGER NOT NULL
                );
            
            INSERT INTO public.migrations (migration, batch) VALUES (\'2016_04_03_185955_nmr_sql\', 1);
        ');
    }
}
