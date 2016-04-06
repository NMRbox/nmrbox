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
            
            
            
            DO
            $body$
            BEGIN
               IF NOT EXISTS (
                  SELECT *
                  FROM   pg_catalog.pg_user
                  WHERE  usename = \'gweatherby\') THEN
            
                  CREATE ROLE gweatherby LOGIN PASSWORD \'secret\';
               END IF;
            END
            $body$;
            
            DO
            $body$
            BEGIN
               IF NOT EXISTS (
                  SELECT *
                  FROM   pg_catalog.pg_user
                  WHERE  usename = \'nmrbox\') THEN
            
                  CREATE ROLE nmrbox LOGIN PASSWORD \'secret\';
               END IF;
            END
            $body$;
            
            DO
            $body$
            BEGIN
               IF NOT EXISTS (
                  SELECT *
                  FROM   pg_catalog.pg_user
                  WHERE  usename = \'laravel\') THEN
            
                  CREATE ROLE laravel LOGIN PASSWORD \'nmr-laravel!\';
               END IF;
            END
            $body$;
            
            
            
            
            
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
            
                            return \'MODIFY\';
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
            -- Name: institutions_id_seq; Type: SEQUENCE; Schema: public; Owner: gweatherby
            --
            
            CREATE SEQUENCE institutions_id_seq
                START WITH 1
                INCREMENT BY 1
                NO MINVALUE
                NO MAXVALUE
                CACHE 1;
            
            
            ALTER TABLE public.institutions_id_seq OWNER TO gweatherby;
            
            --
            -- Name: institutions; Type: TABLE; Schema: public; Owner: gweatherby; Tablespace: 
            --
            
            CREATE TABLE institutions (
                department character varying(32) NOT NULL,
                id integer DEFAULT nextval(\'institutions_id_seq\'::regclass) NOT NULL,
                institution_type character varying(32) NOT NULL,
                name character varying(256) NOT NULL
            );
            
            
            ALTER TABLE public.institutions OWNER TO gweatherby;
            
            --
            -- Name: COLUMN institutions.institution_type; Type: COMMENT; Schema: public; Owner: gweatherby
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
                first_name VARCHAR(32) NOT NULL,
                last_name VARCHAR(64) NOT NULL,
                email character varying(256) NOT NULL,
                pi character varying(64) NOT NULL,
                nmrbox_acct character varying(32),
                address1 VARCHAR(128) DEFAULT NULL,
                city VARCHAR(64) DEFAULT NULL,
                country VARCHAR(64) DEFAULT NULL,
                institution_id integer,
                job_title VARCHAR(32) DEFAULT NULL,
                state_province VARCHAR(32) DEFAULT NULL,
                time_zone_id integer DEFAULT 153 NOT NULL,
                zip_code VARCHAR(32) DEFAULT NULL,
                address2  character varying(128) DEFAULT NULL,
                address3  character varying(128) DEFAULT NULL
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
                license_comment text DEFAULT \'\',
                free_to_redistribute boolean,
                devel_contacted boolean DEFAULT false,
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
            -- Name: survey; Type: TABLE; Schema: public; Owner: gweatherby; Tablespace: 
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
            
            
            ALTER TABLE public.survey OWNER TO gweatherby;
            
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
            -- Name: timezones; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
            --
            
            CREATE TABLE timezones (
                id integer NOT NULL,
                zone character varying(64) NOT NULL
            );
            
            
            ALTER TABLE public.timezones OWNER TO postgres;
            
            --
            -- Name: timezones_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
            --
            
            CREATE SEQUENCE timezones_id_seq
                START WITH 1
                INCREMENT BY 1
                NO MINVALUE
                NO MAXVALUE
                CACHE 1;
            
            
            ALTER TABLE public.timezones_id_seq OWNER TO postgres;
            
            --
            -- Name: timezones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
            --
            
            ALTER SEQUENCE timezones_id_seq OWNED BY timezones.id;
            
            
            --
            -- Name: users; Type: TABLE; Schema: public; Owner: laravel; Tablespace: 
            --
            
            CREATE TABLE users (
                id integer NOT NULL,
                email character varying(255) NOT NULL,
                password character varying(255) NOT NULL,
                permissions text,
                last_login timestamp(0) without time zone,
                first_name character varying(255),
                last_name character varying(255),
                created_at timestamp(0) without time zone NOT NULL,
                updated_at timestamp(0) without time zone NOT NULL,
                institution character varying(255) NOT NULL,
                deleted_at timestamp(0) without time zone
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
            -- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
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
            
            -- COPY activations (id, user_id, code, completed, completed_at, created_at, updated_at) FROM stdin;
            -- 1	1	18KQ6pyo5GUu4WJn0CpfiGaErHwgSgRM	t	2016-02-21 20:56:31	2016-02-21 20:56:31	2016-02-21 20:56:31
            -- \.
            
            insert into activations (id, user_id, code, completed, completed_at, created_at, updated_at) VALUES
                (1,	1,	\'18KQ6pyo5GUu4WJn0CpfiGaErHwgSgRM\',	true,	\'2016-02-21 20:56:31\',	\'2016-02-21 20:56:31\',	\'2016-02-21 20:56:31\' );
            
            
            --
            -- Name: activations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'activations_id_seq\', 1, true);
            
            
            --
            -- Data for Name: blog_categories; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY blog_categories (id, title, created_at, updated_at, deleted_at) FROM stdin;
            -- \.
            
            
            --
            -- Name: blog_categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'blog_categories_id_seq\', 1, false);
            
            
            --
            -- Data for Name: blog_comments; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY blog_comments (id, blog_id, name, email, website, comment, created_at, updated_at, deleted_at) FROM stdin;
            -- \.
            
            
            --
            -- Name: blog_comments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'blog_comments_id_seq\', 1, false);
            
            
            --
            -- Data for Name: blogs; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY blogs (id, blog_category_id, user_id, title, content, image, views, slug, featured, created_at, updated_at, deleted_at) FROM stdin;
            -- \.
            
            
            --
            -- Name: blogs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'blogs_id_seq\', 1, false);
            
            
            --
            -- Data for Name: citation_person; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY citation_person (person_id, citation_id) FROM stdin;
            -- \.
            
            
            --
            -- Data for Name: citation_software; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY citation_software (software_id, citation_id) FROM stdin;
            -- \.
            
            
            --
            -- Data for Name: citation_types; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY citation_types (id, name) FROM stdin;
            -- \.
            
            
            --
            -- Name: citation_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'citation_types_id_seq\', 1, false);
            
            
            --
            -- Data for Name: citations; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY citations (id, citation_type_id, title, author, year, journal, volume, issue, page_start, page_end, publisher, pubmed, note) FROM stdin;
            -- \.
            
            
            --
            -- Name: citations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'citations_id_seq\', 1, false);
            
            
            --
            -- Data for Name: files; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY files (id, name, slug, label, bdata, size, mime_type, software_id, user_id, role_id) FROM stdin;
            -- \.
            
            
            --
            -- Name: files_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'files_id_seq\', 1, false);
            
            
            --
            -- Data for Name: institutions; Type: TABLE DATA; Schema: public; Owner: gweatherby
            --
            
            -- COPY institutions (department, id, institution_type, name) FROM stdin;
            -- \.
            
            
            --
            -- Name: institutions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gweatherby
            --
            
            SELECT pg_catalog.setval(\'institutions_id_seq\', 1, false);
            
            
            --
            -- Data for Name: lab_person; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY lab_person (person_id, lab_id, developer) FROM stdin;
            -- \.
            
            
            --
            -- Data for Name: lab_role_person; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY lab_role_person (person_id, lab_role_id, software_id) FROM stdin;
            -- \.
            
            
            --
            -- Data for Name: lab_roles; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY lab_roles (id, name, slug) FROM stdin;
            -- \.
            
            
            --
            -- Name: lab_roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'lab_roles_id_seq\', 1, false);
            
            
            --
            -- Data for Name: lab_software; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY lab_software (software_id, lab_id) FROM stdin;
            -- \.
            
            
            --
            -- Data for Name: labs; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY labs (id, name, institution, pi) FROM stdin;
            -- \.
            
            
            --
            -- Name: labs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'labs_id_seq\', 1, false);
            
            
            --
            -- Data for Name: menu_software; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY menu_software (software_id, menu_id) FROM stdin;
            -- \.
            
            
            --
            -- Data for Name: menus; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY menus (id, label) FROM stdin;
            -- \.
            
            
            --
            -- Name: menus_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'menus_id_seq\', 1, false);
            
            
            --
            -- Data for Name: pages; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY pages (id, title, user_id, content, slug, created_at, updated_at, deleted_at) FROM stdin;
            -- \.
            
            
            --
            -- Name: pages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'pages_id_seq\', 1, false);
            
            
            --
            -- Data for Name: persistences; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY persistences (id, user_id, code, created_at, updated_at) FROM stdin;
            -- 6	1	M4wz7GHXIJIiSDQUXylFbyN2UNYNWe4J	2016-02-25 03:28:58	2016-02-25 03:28:58
            -- 8	1	Dvlrwk6gJVMkQJXNjaPTQ4A5vOsZZxz0	2016-02-25 04:47:24	2016-02-25 04:47:24
            -- 9	1	V3Zcn01JOmvdlanMch44vC7T83FKScMh	2016-02-25 05:37:06	2016-02-25 05:37:06
            -- 10	1	9fvQVwuArxLwu69lGtTYmE0Alz5t94bT	2016-02-25 13:14:12	2016-02-25 13:14:12
            -- 11	1	wTcTR7ZX8t26OtAkBDK9fwsTP6nguaZf	2016-02-25 19:40:45	2016-02-25 19:40:45
            -- 14	1	skeArjSsFsY8lKvWY9PKjkLMH4tRrgZi	2016-03-03 14:30:41	2016-03-03 14:30:41
            -- 15	1	Ppb2A9wxiHbDqleaNizfQKXdy2h1ZBdH	2016-03-03 15:05:05	2016-03-03 15:05:05
            -- 16	1	lHlcAFIFLUQAb9p4AegDVWQ0VkaUSxyq	2016-03-14 13:59:40	2016-03-14 13:59:40
            -- 17	1	RyTIaAWaG40fNrtg1OCa6qPwffpuICnm	2016-03-21 11:55:00	2016-03-21 11:55:00
            -- 18	1	9rOmXXRA6E8gC4DDMr0qNKInAYiR0wA3	2016-03-21 12:59:44	2016-03-21 12:59:44
            -- 19	1	K6IkQeBVb7FpsySV8Hra3dj2O72VJ3Wb	2016-03-22 15:59:01	2016-03-22 15:59:01
            -- 20	1	YUR6Vsl0sUw6NosLPkYi0sqWj8iijI2y	2016-03-22 19:27:02	2016-03-22 19:27:02
            -- 21	1	8Wka7T7kaRe4eyGWrla7cVc6Iu6ha6RU	2016-03-22 20:08:41	2016-03-22 20:08:41
            -- 22	1	aywZa3IxCtNRqnAYXQmjuHzq9VKAkoIa	2016-03-22 20:25:02	2016-03-22 20:25:02
            -- 23	1	U1d3Hw0Gh8RyYNyJhz8lKQzudXO6j9oc	2016-03-22 20:37:46	2016-03-22 20:37:46
            -- \.
            
            
            
            
            -- We don\'t need to save ancient cookies, so commenting out
            
            -- insert into persistences (id, user_id, code, created_at, updated_at) VALUES
            --       ( 6,   1,     \'M4wz7GHXIJIiSDQUXylFbyN2UNYNWe4J\',    \'2016-02-25 03:28:58\',     \'2016-02-25 03:28:58\' ),
            --       ( 8,   1,     \'Dvlrwk6gJVMkQJXNjaPTQ4A5vOsZZxz0\',    \'2016-02-25 04:47:24\',     \'2016-02-25 04:47:24\' ),
            --       ( 9,   1,     \'V3Zcn01JOmvdlanMch44vC7T83FKScMh\',    \'2016-02-25 05:37:06\',     \'2016-02-25 05:37:06\' ),
            --       ( 10,  1,     \'9fvQVwuArxLwu69lGtTYmE0Alz5t94bT\',    \'2016-02-25 13:14:12\',     \'2016-02-25 13:14:12\' ),
            --       ( 11,  1,     \'wTcTR7ZX8t26OtAkBDK9fwsTP6nguaZf\',    \'2016-02-25 19:40:45\',     \'2016-02-25 19:40:45\' ),
            --       ( 14,  1,     \'skeArjSsFsY8lKvWY9PKjkLMH4tRrgZi\',    \'2016-03-03 14:30:41\',     \'2016-03-03 14:30:41\' ),
            --       ( 15,  1,     \'Ppb2A9wxiHbDqleaNizfQKXdy2h1ZBdH\',    \'2016-03-03 15:05:05\',     \'2016-03-03 15:05:05\' ),
            --       ( 16,  1,     \'lHlcAFIFLUQAb9p4AegDVWQ0VkaUSxyq\',    \'2016-03-14 13:59:40\',     \'2016-03-14 13:59:40\' ),
            --       ( 17,  1,     \'RyTIaAWaG40fNrtg1OCa6qPwffpuICnm\',    \'2016-03-21 11:55:00\',     \'2016-03-21 11:55:00\' ),
            --       ( 18,  1,     \'9rOmXXRA6E8gC4DDMr0qNKInAYiR0wA3\',    \'2016-03-21 12:59:44\',     \'2016-03-21 12:59:44\' ),
            --       ( 19,  1,     \'K6IkQeBVb7FpsySV8Hra3dj2O72VJ3Wb\',    \'2016-03-22 15:59:01\',     \'2016-03-22 15:59:01\' ),
            --       ( 20,  1,     \'YUR6Vsl0sUw6NosLPkYi0sqWj8iijI2y\',    \'2016-03-22 19:27:02\',     \'2016-03-22 19:27:02\' ),
            --       ( 21,  1,     \'8Wka7T7kaRe4eyGWrla7cVc6Iu6ha6RU\',    \'2016-03-22 20:08:41\',     \'2016-03-22 20:08:41\' ),
            --       ( 22,  1,     \'aywZa3IxCtNRqnAYXQmjuHzq9VKAkoIa\',    \'2016-03-22 20:25:02\',     \'2016-03-22 20:25:02\' ),
            --       ( 23,  1,     \'U1d3Hw0Gh8RyYNyJhz8lKQzudXO6j9oc\',    \'2016-03-22 20:37:46\',     \'2016-03-22 20:37:46\' );
            
            
            --
            -- Name: persistences_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'persistences_id_seq\', 2, true);
            
            
            --
            -- Data for Name: person_software; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY person_software (person_id, software_id) FROM stdin;
            -- \.
            
            
            --
            -- Data for Name: persons; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY persons (id, first_name, last_name, email, pi, nmrbox_acct, institution_id, time_zone_id) FROM stdin;
            -- 2	Dillon	Jones	dillons.z.jones@gmail.com	asd	NULL	NULL	153
            -- 3	Dillon	Jones	dillozn.z.jones@gmail.com	asdasd	NULL	NULL	153
            -- 4	Dillon	Jones	dilloan.z.jones@gmail.com	qwe	NULL	NULL	153
            -- 5	Gerard	Weatherby	GWeatherby@uchc.edu	Hoch	NULL	NULL	153
            -- 7	Gerard2	Weatherby	junk@uchc.edu	Hoch	NULL	NULL	153
            -- 1	Dillon	Jones	dillon.z.jones@gmail.com	asd	2	NULL	153
            -- 8	Renhao	Li---------------	renhao.li@emory.edu	Renhao Li	NULL	NULL	153
            -- 9	Patrick	Donabedian	pdonabedian@unm.edu	Eva Chi	NULL	NULL	153
            -- 10	Colin	Smith	colin.smith@mpibpc.mpg.de	Christian Griesinger	NULL	NULL	153
            -- 11	Ramya	Billur	r0bill01@louisville.edu	Dr.Maurer	NULL	NULL	153
            -- 12	Randy	Stockbridge	stockbr@umich.edu	Stockbridge	NULL	NULL	153
            -- 13	Mike	Barber	michael.barber@chem.ox.ac.uk	AJB	NULL	NULL	153
            -- 14	Ryan	Mahling	ryan-mahling@uiowa.edu	Dr. Shea	NULL	NULL	153
            -- 15	sherry	leung	ssl1@sfu.ca	Jenifer Thewalt	NULL	NULL	153
            -- 16	Elliott	Stollar	elliott.stollar@enmu.edu	Elliott Stollar	NULL	NULL	153
            -- \.
                      
            insert into persons (id, first_name, last_name, email, pi, nmrbox_acct, institution_id, time_zone_id) VALUES
                ( 2,     \'Dillon\',      \'Jones\',        \'dillon.z.jones@gmail.com\',           \'UCHC PI\',                  NULL,    NULL,    153 ),
                ( 3,     \'Dillon\',      \'Jones\',        \'dillozn.z.jones@gmail.com\',          \'asdasd\',               NULL,    NULL,    153 ),
                ( 4,     \'Dillon\',      \'Jones\',        \'dilloan.z.jones@gmail.com\',          \'qwe\',                  NULL,    NULL,    153 ),
                ( 5,     \'Gerard\',      \'Weatherby\',    \'GWeatherby@uchc.edu\',                \'Hoch\',                 NULL,    NULL,    153 ),
                ( 7,     \'Gerard2\',     \'Weatherby\',    \'junk@uchc.edu\',                      \'Hoch\',                 NULL,    NULL,    153 ),
                ( 1,     \'Dillon\',      \'Jones\',        \'dillon.z.jones@gmail.com\',           \'asd\',                  2,       NULL,    153 ),
                ( 8,     \'Renhao\',      \'Li\',           \'renhao.li@emory.edu\',                \'Renhao Li\',            NULL,    NULL,    153 ),
                ( 9,     \'Patrick\',     \'Donabedian\',   \'pdonabedian@unm.edu\',                \'Eva Chi\',              NULL,    NULL,    153 ),
                ( 10,    \'Colin\',       \'Smith\',        \'colin.smith@mpibpc.mpg.de\',          \'Christian Griesinger\', NULL,    NULL,    153 ),
                ( 11,    \'Ramya\',       \'Billur\',       \'r0bill01@louisville.edu\',            \'Dr. Maurer\',           NULL,    NULL,    153 ),
                ( 12,    \'Randy\',       \'Stockbridge\',  \'stockbr@umich.edu\',                  \'Stockbridge\',          NULL,    NULL,    153 ),
                ( 13,    \'Mike\',        \'Barber\',       \'michael.barber@chem.ox.ac.uk\',       \'AJB\',                  NULL,    NULL,    153 ),
                ( 14,    \'Ryan\',        \'Mahling\',      \'ryan-mahling@uiowa.edu\',             \'Dr. Shea\',             NULL,    NULL,    153 ),
                ( 15,    \'sherry\',      \'leung\',        \'ssl1@sfu.ca\',                        \'Jenifer Thewalt\',      NULL,    NULL,    153 ),
                ( 16,    \'Elliott\',     \'Stollar\',      \'elliott.stollar@enmu.edu\',           \'Elliott Stollar\',      NULL,    NULL,    153 );
            
            
            --
            -- Name: persons_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'persons_id_seq\', 16, true);
            
            
            --
            -- Data for Name: reminders; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY reminders (id, user_id, code, completed, completed_at, created_at, updated_at) FROM stdin;
            -- \.
            
            
            --
            -- Name: reminders_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'reminders_id_seq\', 1, false);
            
            
            --
            -- Data for Name: role_users; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            insert into role_users (user_id, role_id, created_at, updated_at) VALUES
                ( 1,	1,	\'2016-02-21 20:56:31\',	\'2016-02-21 20:56:31\' );
            
            
            --
            -- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            insert into roles (id, slug, name, permissions, created_at, updated_at) VALUES
                ( 1,	\'admin\',	\'Admin\',			\'{"admin":1}\',	\'2016-02-21 20:56:31\',	\'2016-02-21 20:56:31\' ),
                ( 2,	\'user\',		\'User\',				NULL,				\'2016-02-21 20:56:31\',	\'2016-02-21 20:56:31\' ),
                ( 3,	\'public\',	\'Public\',			NULL,				\'2016-02-21 20:56:31\',	\'2016-02-21 20:56:31\' );
            
            
            --
            -- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'roles_id_seq\', 1, false);
            
            
            --
            -- Data for Name: software; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY software (id, name, short_title, long_title, synopsis, public_release, description, license_comment, free_to_redistribute, devel_contacted, devel_include, custom_license, uchc_legal_approve, devel_redistrib_doc, devel_active, devel_status, contact_id, devel_redistribute_doc, execute_license, image, modified_license, \'original license\', url) FROM stdin;
            -- \.
            
            
            --
            -- Name: software_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'software_id_seq\', 1, false);
            
            
            --
            -- Data for Name: software_tag; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY software_tag (software_id, tag_id) FROM stdin;
            -- \.
            
            
            --
            -- Data for Name: software_version_vm; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY software_version_vm (software_version_id, vm_id) FROM stdin;
            -- \.
            
            
            --
            -- Data for Name: software_versions; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY software_versions (id, software_id, version) FROM stdin;
            -- \.
            
            
            --
            -- Name: software_versions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'software_versions_id_seq\', 1, false);
            
            
            --
            -- Data for Name: survey; Type: TABLE DATA; Schema: public; Owner: gweatherby
            --
            
            -- COPY survey (comments, desired_software_packages, id, nmr_imaging, nmr_other, nmr_solid_state, nmr_solution, persons_id, study_computational, study_dna, study_dynamics, study_metabolomics, study_other, study_proteins, study_rna, study_small_molecules) FROM stdin;
            -- \.
            
            
            --
            -- Data for Name: svn_document_software; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY svn_document_software (software_id, svn_document_id, created_at, updated_at) FROM stdin;
            -- \.
            
            
            --
            -- Data for Name: svn_documents; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY svn_documents (id, type, display, bdata) FROM stdin;
            -- \.
            
            
            --
            -- Name: svn_documents_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'svn_documents_id_seq\', 1, false);
            
            
            --
            -- Data for Name: taggable_taggables; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY taggable_taggables (tag_id, taggable_id, taggable_type, created_at, updated_at) FROM stdin;
            -- \.
            
            
            --
            -- Data for Name: taggable_tags; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY taggable_tags (tag_id, name, normalized, created_at, updated_at) FROM stdin;
            -- \.
            
            
            --
            -- Name: taggable_tags_tag_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'taggable_tags_tag_id_seq\', 1, false);
            
            
            --
            -- Data for Name: tags; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY tags (id, keyword) FROM stdin;
            -- \.
            
            
            --
            -- Name: tags_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'tags_id_seq\', 1, false);
            
            
            --
            -- Data for Name: throttle; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            insert into throttle (id, user_id, type, ip, created_at, updated_at) VALUES
                ( 1,	NULL,	\'global\',	NULL,			\'2016-03-22 15:54:12\',	\'2016-03-22 15:54:12\' ),
                ( 2,	NULL,	\'ip\',		\'10.91.27.91\',	\'2016-03-22 15:54:12\',	\'2016-03-22 15:54:12\' );
            
            
            --
            -- Name: throttle_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'throttle_id_seq\', 2, true);
            
            
            --
            -- Data for Name: timezones; Type: TABLE DATA; Schema: public; Owner: postgres
            --
            
            insert into timezones (id, zone) VALUES
                ( 1,     \'Africa/Abidjan\' ),
                ( 2,     \'Africa/Accra\' ),
                ( 3,     \'Africa/Addis_Ababa\' ),
                ( 4,     \'Africa/Algiers\' ),
                ( 5,     \'Africa/Asmara\' ),
                ( 6,     \'Africa/Bamako\' ),
                ( 7,     \'Africa/Bangui\' ),
                ( 8,     \'Africa/Banjul\' ),
                ( 9,     \'Africa/Bissau\' ),
                ( 10,    \'Africa/Blantyre\' ),
                ( 11,    \'Africa/Brazzaville\' ),
                ( 12,    \'Africa/Bujumbura\' ),
                ( 13,    \'Africa/Cairo\' ),
                ( 14,    \'Africa/Casablanca\' ),
                ( 15,    \'Africa/Ceuta\' ),
                ( 16,    \'Africa/Conakry\' ),
                ( 17,    \'Africa/Dakar\' ),
                ( 18,    \'Africa/Dar_es_Salaam\' ),
                ( 19,    \'Africa/Djibouti\' ),
                ( 20,    \'Africa/Douala\' ),
                ( 21,    \'Africa/El_Aaiun\' ),
                ( 22,    \'Africa/Freetown\' ),
                ( 23,    \'Africa/Gaborone\' ),
                ( 24,    \'Africa/Harare\' ),
                ( 25,    \'Africa/Johannesburg\' ),
                ( 26,    \'Africa/Juba\' ),
                ( 27,    \'Africa/Kampala\' ),
                ( 28,    \'Africa/Khartoum\' ),
                ( 29,    \'Africa/Kigali\' ),
                ( 30,    \'Africa/Kinshasa\' ),
                ( 31,    \'Africa/Lagos\' ),
                ( 32,    \'Africa/Libreville\' ),
                ( 33,    \'Africa/Lome\' ),
                ( 34,    \'Africa/Luanda\' ),
                ( 35,    \'Africa/Lubumbashi\' ),
                ( 36,    \'Africa/Lusaka\' ),
                ( 37,    \'Africa/Malabo\' ),
                ( 38,    \'Africa/Maputo\' ),
                ( 39,    \'Africa/Maseru\' ),
                ( 40,    \'Africa/Mbabane\' ),
                ( 41,    \'Africa/Mogadishu\' ),
                ( 42,    \'Africa/Monrovia\' ),
                ( 43,    \'Africa/Nairobi\' ),
                ( 44,    \'Africa/Ndjamena\' ),
                ( 45,    \'Africa/Niamey\' ),
                ( 46,    \'Africa/Nouakchott\' ),
                ( 47,    \'Africa/Ouagadougou\' ),
                ( 48,    \'Africa/Porto-Novo\' ),
                ( 49,    \'Africa/Sao_Tome\' ),
                ( 50,    \'Africa/Tripoli\' ),
                ( 51,    \'Africa/Tunis\' ),
                ( 52,    \'Africa/Windhoek\' ),
                ( 53,    \'America/Adak\' ),
                ( 54,    \'America/Anchorage\' ),
                ( 55,    \'America/Anguilla\' ),
                ( 56,    \'America/Antigua\' ),
                ( 57,    \'America/Araguaina\' ),
                ( 58,    \'America/Argentina/Buenos_Aires\' ),
                ( 59,    \'America/Argentina/Catamarca\' ),
                ( 60,    \'America/Argentina/Cordoba\' ),
                ( 61,    \'America/Argentina/Jujuy\' ),
                ( 62,    \'America/Argentina/La_Rioja\' ),
                ( 63,    \'America/Argentina/Mendoza\' ),
                ( 64,    \'America/Argentina/Rio_Gallegos\' ),
                ( 65,    \'America/Argentina/Salta\' ),
                ( 66,    \'America/Argentina/San_Juan\' ),
                ( 67,    \'America/Argentina/San_Luis\' ),
                ( 68,    \'America/Argentina/Tucuman\' ),
                ( 69,    \'America/Argentina/Ushuaia\' ),
                ( 70,    \'America/Aruba\' ),
                ( 71,    \'America/Asuncion\' ),
                ( 72,    \'America/Atikokan\' ),
                ( 73,    \'America/Bahia\' ),
                ( 74,    \'America/Bahia_Banderas\' ),
                ( 75,    \'America/Barbados\' ),
                ( 76,    \'America/Belem\' ),
                ( 77,    \'America/Belize\' ),
                ( 78,    \'America/Blanc-Sablon\' ),
                ( 79,    \'America/Boa_Vista\' ),
                ( 80,    \'America/Bogota\' ),
                ( 81,    \'America/Boise\' ),
                ( 82,    \'America/Cambridge_Bay\' ),
                ( 83,    \'America/Campo_Grande\' ),
                ( 84,    \'America/Cancun\' ),
                ( 85,    \'America/Caracas\' ),
                ( 86,    \'America/Cayenne\' ),
                ( 87,    \'America/Cayman\' ),
                ( 88,    \'America/Chicago\' ),
                ( 89,    \'America/Chihuahua\' ),
                ( 90,    \'America/Costa_Rica\' ),
                ( 91,    \'America/Creston\' ),
                ( 92,    \'America/Cuiaba\' ),
                ( 93,    \'America/Curacao\' ),
                ( 94,    \'America/Danmarkshavn\' ),
                ( 95,    \'America/Dawson\' ),
                ( 96,    \'America/Dawson_Creek\' ),
                ( 97,    \'America/Denver\' ),
                ( 98,    \'America/Detroit\' ),
                ( 99,    \'America/Dominica\' ),
                ( 100,   \'America/Edmonton\' ),
                ( 101,   \'America/Eirunepe\' ),
                ( 102,   \'America/El_Salvador\' ),
                ( 103,   \'America/Fort_Nelson\' ),
                ( 104,   \'America/Fortaleza\' ),
                ( 105,   \'America/Glace_Bay\' ),
                ( 106,   \'America/Godthab\' ),
                ( 107,   \'America/Goose_Bay\' ),
                ( 108,   \'America/Grand_Turk\' ),
                ( 109,   \'America/Grenada\' ),
                ( 110,   \'America/Guadeloupe\' ),
                ( 111,   \'America/Guatemala\' ),
                ( 112,   \'America/Guayaquil\' ),
                ( 113,   \'America/Guyana\' ),
                ( 114,   \'America/Halifax\' ),
                ( 115,   \'America/Havana\' ),
                ( 116,   \'America/Hermosillo\' ),
                ( 117,   \'America/Indiana/Indianapolis\' ),
                ( 118,   \'America/Indiana/Knox\' ),
                ( 119,   \'America/Indiana/Marengo\' ),
                ( 120,   \'America/Indiana/Petersburg\' ),
                ( 121,   \'America/Indiana/Tell_City\' ),
                ( 122,   \'America/Indiana/Vevay\' ),
                ( 123,   \'America/Indiana/Vincennes\' ),
                ( 124,   \'America/Indiana/Winamac\' ),
                ( 125,   \'America/Inuvik\' ),
                ( 126,   \'America/Iqaluit\' ),
                ( 127,   \'America/Jamaica\' ),
                ( 128,   \'America/Juneau\' ),
                ( 129,   \'America/Kentucky/Louisville\' ),
                ( 130,   \'America/Kentucky/Monticello\' ),
                ( 131,   \'America/Kralendijk\' ),
                ( 132,   \'America/La_Paz\' ),
                ( 133,   \'America/Lima\' ),
                ( 134,   \'America/Los_Angeles\' ),
                ( 135,   \'America/Lower_Princes\' ),
                ( 136,   \'America/Maceio\' ),
                ( 137,   \'America/Managua\' ),
                ( 138,   \'America/Manaus\' ),
                ( 139,   \'America/Marigot\' ),
                ( 140,   \'America/Martinique\' ),
                ( 141,   \'America/Matamoros\' ),
                ( 142,   \'America/Mazatlan\' ),
                ( 143,   \'America/Menominee\' ),
                ( 144,   \'America/Merida\' ),
                ( 145,   \'America/Metlakatla\' ),
                ( 146,   \'America/Mexico_City\' ),
                ( 147,   \'America/Miquelon\' ),
                ( 148,   \'America/Moncton\' ),
                ( 149,   \'America/Monterrey\' ),
                ( 150,   \'America/Montevideo\' ),
                ( 151,   \'America/Montserrat\' ),
                ( 152,   \'America/Nassau\' ),
                ( 153,   \'America/New_York\' ),
                ( 154,   \'America/Nipigon\' ),
                ( 155,   \'America/Nome\' ),
                ( 156,   \'America/Noronha\' ),
                ( 157,   \'America/North_Dakota/Beulah\' ),
                ( 158,   \'America/North_Dakota/Center\' ),
                ( 159,   \'America/North_Dakota/New_Salem\' ),
                ( 160,   \'America/Ojinaga\' ),
                ( 161,   \'America/Panama\' ),
                ( 162,   \'America/Pangnirtung\' ),
                ( 163,   \'America/Paramaribo\' ),
                ( 164,   \'America/Phoenix\' ),
                ( 165,   \'America/Port-au-Prince\' ),
                ( 166,   \'America/Port_of_Spain\' ),
                ( 167,   \'America/Porto_Velho\' ),
                ( 168,   \'America/Puerto_Rico\' ),
                ( 169,   \'America/Rainy_River\' ),
                ( 170,   \'America/Rankin_Inlet\' ),
                ( 171,   \'America/Recife\' ),
                ( 172,   \'America/Regina\' ),
                ( 173,   \'America/Resolute\' ),
                ( 174,   \'America/Rio_Branco\' ),
                ( 175,   \'America/Santa_Isabel\' ),
                ( 176,   \'America/Santarem\' ),
                ( 177,   \'America/Santiago\' ),
                ( 178,   \'America/Santo_Domingo\' ),
                ( 179,   \'America/Sao_Paulo\' ),
                ( 180,   \'America/Scoresbysund\' ),
                ( 181,   \'America/Sitka\' ),
                ( 182,   \'America/St_Barthelemy\' ),
                ( 183,   \'America/St_Johns\' ),
                ( 184,   \'America/St_Kitts\' ),
                ( 185,   \'America/St_Lucia\' ),
                ( 186,   \'America/St_Thomas\' ),
                ( 187,   \'America/St_Vincent\' ),
                ( 188,   \'America/Swift_Current\' ),
                ( 189,   \'America/Tegucigalpa\' ),
                ( 190,   \'America/Thule\' ),
                ( 191,   \'America/Thunder_Bay\' ),
                ( 192,   \'America/Tijuana\' ),
                ( 193,   \'America/Toronto\' ),
                ( 194,   \'America/Tortola\' ),
                ( 195,   \'America/Vancouver\' ),
                ( 196,   \'America/Whitehorse\' ),
                ( 197,   \'America/Winnipeg\' ),
                ( 198,   \'America/Yakutat\' ),
                ( 199,   \'America/Yellowknife\' ),
                ( 200,   \'Antarctica/Casey\' ),
                ( 201,   \'Antarctica/Davis\' ),
                ( 202,   \'Antarctica/DumontDUrville\' ),
                ( 203,   \'Antarctica/Macquarie\' ),
                ( 204,   \'Antarctica/Mawson\' ),
                ( 205,   \'Antarctica/McMurdo\' ),
                ( 206,   \'Antarctica/Palmer\' ),
                ( 207,   \'Antarctica/Rothera\' ),
                ( 208,   \'Antarctica/Syowa\' ),
                ( 209,   \'Antarctica/Troll\' ),
                ( 210,   \'Antarctica/Vostok\' ),
                ( 211,   \'Arctic/Longyearbyen\' ),
                ( 212,   \'Asia/Aden\' ),
                ( 213,   \'Asia/Almaty\' ),
                ( 214,   \'Asia/Amman\' ),
                ( 215,   \'Asia/Anadyr\' ),
                ( 216,   \'Asia/Aqtau\' ),
                ( 217,   \'Asia/Aqtobe\' ),
                ( 218,   \'Asia/Ashgabat\' ),
                ( 219,   \'Asia/Baghdad\' ),
                ( 220,   \'Asia/Bahrain\' ),
                ( 221,   \'Asia/Baku\' ),
                ( 222,   \'Asia/Bangkok\' ),
                ( 223,   \'Asia/Beirut\' ),
                ( 224,   \'Asia/Bishkek\' ),
                ( 225,   \'Asia/Brunei\' ),
                ( 226,   \'Asia/Chita\' ),
                ( 227,   \'Asia/Choibalsan\' ),
                ( 228,   \'Asia/Colombo\' ),
                ( 229,   \'Asia/Damascus\' ),
                ( 230,   \'Asia/Dhaka\' ),
                ( 231,   \'Asia/Dili\' ),
                ( 232,   \'Asia/Dubai\' ),
                ( 233,   \'Asia/Dushanbe\' ),
                ( 234,   \'Asia/Gaza\' ),
                ( 235,   \'Asia/Hebron\' ),
                ( 236,   \'Asia/Ho_Chi_Minh\' ),
                ( 237,   \'Asia/Hong_Kong\' ),
                ( 238,   \'Asia/Hovd\' ),
                ( 239,   \'Asia/Irkutsk\' ),
                ( 240,   \'Asia/Jakarta\' ),
                ( 241,   \'Asia/Jayapura\' ),
                ( 242,   \'Asia/Jerusalem\' ),
                ( 243,   \'Asia/Kabul\' ),
                ( 244,   \'Asia/Kamchatka\' ),
                ( 245,   \'Asia/Karachi\' ),
                ( 246,   \'Asia/Kathmandu\' ),
                ( 247,   \'Asia/Khandyga\' ),
                ( 248,   \'Asia/Kolkata\' ),
                ( 249,   \'Asia/Krasnoyarsk\' ),
                ( 250,   \'Asia/Kuala_Lumpur\' ),
                ( 251,   \'Asia/Kuching\' ),
                ( 252,   \'Asia/Kuwait\' ),
                ( 253,   \'Asia/Macau\' ),
                ( 254,   \'Asia/Magadan\' ),
                ( 255,   \'Asia/Makassar\' ),
                ( 256,   \'Asia/Manila\' ),
                ( 257,   \'Asia/Muscat\' ),
                ( 258,   \'Asia/Nicosia\' ),
                ( 259,   \'Asia/Novokuznetsk\' ),
                ( 260,   \'Asia/Novosibirsk\' ),
                ( 261,   \'Asia/Omsk\' ),
                ( 262,   \'Asia/Oral\' ),
                ( 263,   \'Asia/Phnom_Penh\' ),
                ( 264,   \'Asia/Pontianak\' ),
                ( 265,   \'Asia/Pyongyang\' ),
                ( 266,   \'Asia/Qatar\' ),
                ( 267,   \'Asia/Qyzylorda\' ),
                ( 268,   \'Asia/Rangoon\' ),
                ( 269,   \'Asia/Riyadh\' ),
                ( 270,   \'Asia/Sakhalin\' ),
                ( 271,   \'Asia/Samarkand\' ),
                ( 272,   \'Asia/Seoul\' ),
                ( 273,   \'Asia/Shanghai\' ),
                ( 274,   \'Asia/Singapore\' ),
                ( 275,   \'Asia/Srednekolymsk\' ),
                ( 276,   \'Asia/Taipei\' ),
                ( 277,   \'Asia/Tashkent\' ),
                ( 278,   \'Asia/Tbilisi\' ),
                ( 279,   \'Asia/Tehran\' ),
                ( 280,   \'Asia/Thimphu\' ),
                ( 281,   \'Asia/Tokyo\' ),
                ( 282,   \'Asia/Ulaanbaatar\' ),
                ( 283,   \'Asia/Urumqi\' ),
                ( 284,   \'Asia/Ust-Nera\' ),
                ( 285,   \'Asia/Vientiane\' ),
                ( 286,   \'Asia/Vladivostok\' ),
                ( 287,   \'Asia/Yakutsk\' ),
                ( 288,   \'Asia/Yekaterinburg\' ),
                ( 289,   \'Asia/Yerevan\' ),
                ( 290,   \'Atlantic/Azores\' ),
                ( 291,   \'Atlantic/Bermuda\' ),
                ( 292,   \'Atlantic/Canary\' ),
                ( 293,   \'Atlantic/Cape_Verde\' ),
                ( 294,   \'Atlantic/Faroe\' ),
                ( 295,   \'Atlantic/Madeira\' ),
                ( 296,   \'Atlantic/Reykjavik\' ),
                ( 297,   \'Atlantic/South_Georgia\' ),
                ( 298,   \'Atlantic/St_Helena\' ),
                ( 299,   \'Atlantic/Stanley\' ),
                ( 300,   \'Australia/Adelaide\' ),
                ( 301,   \'Australia/Brisbane\' ),
                ( 302,   \'Australia/Broken_Hill\' ),
                ( 303,   \'Australia/Currie\' ),
                ( 304,   \'Australia/Darwin\' ),
                ( 305,   \'Australia/Eucla\' ),
                ( 306,   \'Australia/Hobart\' ),
                ( 307,   \'Australia/Lindeman\' ),
                ( 308,   \'Australia/Lord_Howe\' ),
                ( 309,   \'Australia/Melbourne\' ),
                ( 310,   \'Australia/Perth\' ),
                ( 311,   \'Australia/Sydney\' ),
                ( 312,   \'Europe/Amsterdam\' ),
                ( 313,   \'Europe/Andorra\' ),
                ( 314,   \'Europe/Athens\' ),
                ( 315,   \'Europe/Belgrade\' ),
                ( 316,   \'Europe/Berlin\' ),
                ( 317,   \'Europe/Bratislava\' ),
                ( 318,   \'Europe/Brussels\' ),
                ( 319,   \'Europe/Bucharest\' ),
                ( 320,   \'Europe/Budapest\' ),
                ( 321,   \'Europe/Busingen\' ),
                ( 322,   \'Europe/Chisinau\' ),
                ( 323,   \'Europe/Copenhagen\' ),
                ( 324,   \'Europe/Dublin\' ),
                ( 325,   \'Europe/Gibraltar\' ),
                ( 326,   \'Europe/Guernsey\' ),
                ( 327,   \'Europe/Helsinki\' ),
                ( 328,   \'Europe/Isle_of_Man\' ),
                ( 329,   \'Europe/Istanbul\' ),
                ( 330,   \'Europe/Jersey\' ),
                ( 331,   \'Europe/Kaliningrad\' ),
                ( 332,   \'Europe/Kiev\' ),
                ( 333,   \'Europe/Lisbon\' ),
                ( 334,   \'Europe/Ljubljana\' ),
                ( 335,   \'Europe/London\' ),
                ( 336,   \'Europe/Luxembourg\' ),
                ( 337,   \'Europe/Madrid\' ),
                ( 338,   \'Europe/Malta\' ),
                ( 339,   \'Europe/Mariehamn\' ),
                ( 340,   \'Europe/Minsk\' ),
                ( 341,   \'Europe/Monaco\' ),
                ( 342,   \'Europe/Moscow\' ),
                ( 343,   \'Europe/Oslo\' ),
                ( 344,   \'Europe/Paris\' ),
                ( 345,   \'Europe/Podgorica\' ),
                ( 346,   \'Europe/Prague\' ),
                ( 347,   \'Europe/Riga\' ),
                ( 348,   \'Europe/Rome\' ),
                ( 349,   \'Europe/Samara\' ),
                ( 350,   \'Europe/San_Marino\' ),
                ( 351,   \'Europe/Sarajevo\' ),
                ( 352,   \'Europe/Simferopol\' ),
                ( 353,   \'Europe/Skopje\' ),
                ( 354,   \'Europe/Sofia\' ),
                ( 355,   \'Europe/Stockholm\' ),
                ( 356,   \'Europe/Tallinn\' ),
                ( 357,   \'Europe/Tirane\' ),
                ( 358,   \'Europe/Uzhgorod\' ),
                ( 359,   \'Europe/Vaduz\' ),
                ( 360,   \'Europe/Vatican\' ),
                ( 361,   \'Europe/Vienna\' ),
                ( 362,   \'Europe/Vilnius\' ),
                ( 363,   \'Europe/Volgograd\' ),
                ( 364,   \'Europe/Warsaw\' ),
                ( 365,   \'Europe/Zagreb\' ),
                ( 366,   \'Europe/Zaporozhye\' ),
                ( 367,   \'Europe/Zurich\' ),
                ( 368,   \'Indian/Antananarivo\' ),
                ( 369,   \'Indian/Chagos\' ),
                ( 370,   \'Indian/Christmas\' ),
                ( 371,   \'Indian/Cocos\' ),
                ( 372,   \'Indian/Comoro\' ),
                ( 373,   \'Indian/Kerguelen\' ),
                ( 374,   \'Indian/Mahe\' ),
                ( 375,   \'Indian/Maldives\' ),
                ( 376,   \'Indian/Mauritius\' ),
                ( 377,   \'Indian/Mayotte\' ),
                ( 378,   \'Indian/Reunion\' ),
                ( 379,   \'Pacific/Apia\' ),
                ( 380,   \'Pacific/Auckland\' ),
                ( 381,   \'Pacific/Bougainville\' ),
                ( 382,   \'Pacific/Chatham\' ),
                ( 383,   \'Pacific/Chuuk\' ),
                ( 384,   \'Pacific/Easter\' ),
                ( 385,   \'Pacific/Efate\' ),
                ( 386,   \'Pacific/Enderbury\' ),
                ( 387,   \'Pacific/Fakaofo\' ),
                ( 388,   \'Pacific/Fiji\' ),
                ( 389,   \'Pacific/Funafuti\' ),
                ( 390,   \'Pacific/Galapagos\' ),
                ( 391,   \'Pacific/Gambier\' ),
                ( 392,   \'Pacific/Guadalcanal\' ),
                ( 393,   \'Pacific/Guam\' ),
                ( 394,   \'Pacific/Honolulu\' ),
                ( 395,   \'Pacific/Johnston\' ),
                ( 396,   \'Pacific/Kiritimati\' ),
                ( 397,   \'Pacific/Kosrae\' ),
                ( 398,   \'Pacific/Kwajalein\' ),
                ( 399,   \'Pacific/Majuro\' ),
                ( 400,   \'Pacific/Marquesas\' ),
                ( 401,   \'Pacific/Midway\' ),
                ( 402,   \'Pacific/Nauru\' ),
                ( 403,   \'Pacific/Niue\' ),
                ( 404,   \'Pacific/Norfolk\' ),
                ( 405,   \'Pacific/Noumea\' ),
                ( 406,   \'Pacific/Pago_Pago\' ),
                ( 407,   \'Pacific/Palau\' ),
                ( 408,   \'Pacific/Pitcairn\' ),
                ( 409,   \'Pacific/Pohnpei\' ),
                ( 410,   \'Pacific/Port_Moresby\' ),
                ( 411,   \'Pacific/Rarotonga\' ),
                ( 412,   \'Pacific/Saipan\' ),
                ( 413,   \'Pacific/Tahiti\' ),
                ( 414,   \'Pacific/Tarawa\' ),
                ( 415,   \'Pacific/Tongatapu\' ),
                ( 416,   \'Pacific/Wake\' ),
                ( 417,   \'Pacific/Wallis\' );
            
            
            --
            -- Name: timezones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
            --
            
            SELECT pg_catalog.setval(\'timezones_id_seq\', 417, true);
            
            
            --
            -- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            insert into users (id, email, password, permissions, last_login, first_name, last_name, created_at, updated_at, institution, deleted_at) VALUES
            ( 1,	\'admin@admin.com\',	\'$2y$10$kEO7UJHYOVhHyo90BRRoSey0BqAMnorvMSzgO8HrnAlEKGVWXj3Me\',	NULL,	\'2016-03-22 20:37:46\',	\'John\',	\'Doe\',	\'2016-02-21 20:56:31\',	\'2016-03-22 20:37:46\',	\'UCHC\',	NULL );
            
            
            --
            -- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: laravel
            --
            
            SELECT pg_catalog.setval(\'users_id_seq\', 1, false);
            
            
            --
            -- Data for Name: vms; Type: TABLE DATA; Schema: public; Owner: laravel
            --
            
            -- COPY vms (id, name, major, minor, variant) FROM stdin;
            -- \.
            
            
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
            -- Name: instiutions_pkey; Type: CONSTRAINT; Schema: public; Owner: gweatherby; Tablespace: 
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
            -- Name: pksurvey; Type: CONSTRAINT; Schema: public; Owner: gweatherby; Tablespace: 
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
            -- Name: timezones_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
            --
            
            ALTER TABLE ONLY timezones
                ADD CONSTRAINT timezones_pkey PRIMARY KEY (id);
            
            
            --
            -- Name: timezones_zone_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
            --
            
            ALTER TABLE ONLY timezones
                ADD CONSTRAINT timezones_zone_key UNIQUE (zone);
            
            
            --
            -- Name: users_email_unique; Type: CONSTRAINT; Schema: public; Owner: laravel; Tablespace: 
            --
            
            ALTER TABLE ONLY users
                ADD CONSTRAINT users_email_unique UNIQUE (email);
            
            
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
            -- Name: fk_survey_persons; Type: FK CONSTRAINT; Schema: public; Owner: gweatherby
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
        //
    }
}
