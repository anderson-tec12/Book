--
-- PostgreSQL database dump
--

-- Dumped from database version 8.4.22
-- Dumped by pg_dump version 9.0.3
-- Started on 2016-05-30 11:50:38

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 8 (class 2615 OID 2839892)
-- Name: custom; Type: SCHEMA; Schema: -; Owner: zioncloud3
--

CREATE SCHEMA custom;


ALTER SCHEMA custom OWNER TO zioncloud3;

--
-- TOC entry 7 (class 2615 OID 2831078)
-- Name: geral; Type: SCHEMA; Schema: -; Owner: zioncloud3
--

CREATE SCHEMA geral;


ALTER SCHEMA geral OWNER TO zioncloud3;

--
-- TOC entry 407 (class 2612 OID 16386)
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: zioncloud3
--

CREATE OR REPLACE PROCEDURAL LANGUAGE plpgsql;


ALTER PROCEDURAL LANGUAGE plpgsql OWNER TO zioncloud3;

SET search_path = custom, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 1628 (class 1259 OID 2839893)
-- Dependencies: 8
-- Name: componente_template; Type: TABLE; Schema: custom; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE componente_template (
    id integer NOT NULL,
    nome character varying(300),
    descricao text,
    instrucoes_uso text,
    modulos character varying(300),
    id_icone1 integer,
    id_icone2 integer,
    cor character varying(8),
    tx_modulos character varying(300),
    status character varying(30),
    ordem smallint,
    id_ferramenta integer,
    grupo character varying(50),
    id_modulo integer,
    tipo character varying(40),
    id_grupo integer
);


ALTER TABLE custom.componente_template OWNER TO zioncloud3;

--
-- TOC entry 1629 (class 1259 OID 2839899)
-- Dependencies: 8 1628
-- Name: componente_template_id_seq; Type: SEQUENCE; Schema: custom; Owner: zioncloud3
--

CREATE SEQUENCE componente_template_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE custom.componente_template_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2082 (class 0 OID 0)
-- Dependencies: 1629
-- Name: componente_template_id_seq; Type: SEQUENCE OWNED BY; Schema: custom; Owner: zioncloud3
--

ALTER SEQUENCE componente_template_id_seq OWNED BY componente_template.id;


--
-- TOC entry 2083 (class 0 OID 0)
-- Dependencies: 1629
-- Name: componente_template_id_seq; Type: SEQUENCE SET; Schema: custom; Owner: zioncloud3
--

SELECT pg_catalog.setval('componente_template_id_seq', 1, false);


--
-- TOC entry 1630 (class 1259 OID 2839901)
-- Dependencies: 8
-- Name: componente_template_item; Type: TABLE; Schema: custom; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE componente_template_item (
    id integer NOT NULL,
    id_item_componente integer,
    id_componente_template integer,
    ordem smallint,
    texto text,
    status character varying(30),
    titulo character varying(300)
);


ALTER TABLE custom.componente_template_item OWNER TO zioncloud3;

--
-- TOC entry 1631 (class 1259 OID 2839907)
-- Dependencies: 1630 8
-- Name: componente_template_item_id_seq; Type: SEQUENCE; Schema: custom; Owner: zioncloud3
--

CREATE SEQUENCE componente_template_item_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE custom.componente_template_item_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2085 (class 0 OID 0)
-- Dependencies: 1631
-- Name: componente_template_item_id_seq; Type: SEQUENCE OWNED BY; Schema: custom; Owner: zioncloud3
--

ALTER SEQUENCE componente_template_item_id_seq OWNED BY componente_template_item.id;


--
-- TOC entry 2086 (class 0 OID 0)
-- Dependencies: 1631
-- Name: componente_template_item_id_seq; Type: SEQUENCE SET; Schema: custom; Owner: zioncloud3
--

SELECT pg_catalog.setval('componente_template_item_id_seq', 1, false);


--
-- TOC entry 1632 (class 1259 OID 2839909)
-- Dependencies: 8
-- Name: grupo_componente_template; Type: TABLE; Schema: custom; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE grupo_componente_template (
    id integer NOT NULL,
    id_ferramenta integer,
    id_modulo integer,
    codigo character varying(50),
    nome character varying(255),
    descricao character varying(255)
);


ALTER TABLE custom.grupo_componente_template OWNER TO zioncloud3;

--
-- TOC entry 1633 (class 1259 OID 2839915)
-- Dependencies: 1632 8
-- Name: grupo_componente_template_id_seq; Type: SEQUENCE; Schema: custom; Owner: zioncloud3
--

CREATE SEQUENCE grupo_componente_template_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE custom.grupo_componente_template_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2087 (class 0 OID 0)
-- Dependencies: 1633
-- Name: grupo_componente_template_id_seq; Type: SEQUENCE OWNED BY; Schema: custom; Owner: zioncloud3
--

ALTER SEQUENCE grupo_componente_template_id_seq OWNED BY grupo_componente_template.id;


--
-- TOC entry 2088 (class 0 OID 0)
-- Dependencies: 1633
-- Name: grupo_componente_template_id_seq; Type: SEQUENCE SET; Schema: custom; Owner: zioncloud3
--

SELECT pg_catalog.setval('grupo_componente_template_id_seq', 1, false);


--
-- TOC entry 1634 (class 1259 OID 2839917)
-- Dependencies: 8
-- Name: item_componente; Type: TABLE; Schema: custom; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE item_componente (
    id integer NOT NULL,
    codigo character varying(30),
    nome character varying(300),
    imagem character varying(300),
    imagem_miniatura character varying(300),
    obs text,
    status character varying(30)
);


ALTER TABLE custom.item_componente OWNER TO zioncloud3;

--
-- TOC entry 1635 (class 1259 OID 2839923)
-- Dependencies: 1634 8
-- Name: item_componente_id_seq; Type: SEQUENCE; Schema: custom; Owner: zioncloud3
--

CREATE SEQUENCE item_componente_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE custom.item_componente_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2090 (class 0 OID 0)
-- Dependencies: 1635
-- Name: item_componente_id_seq; Type: SEQUENCE OWNED BY; Schema: custom; Owner: zioncloud3
--

ALTER SEQUENCE item_componente_id_seq OWNED BY item_componente.id;


--
-- TOC entry 2091 (class 0 OID 0)
-- Dependencies: 1635
-- Name: item_componente_id_seq; Type: SEQUENCE SET; Schema: custom; Owner: zioncloud3
--

SELECT pg_catalog.setval('item_componente_id_seq', 27, true);


--
-- TOC entry 1636 (class 1259 OID 2839925)
-- Dependencies: 8
-- Name: item_template_ferramenta; Type: TABLE; Schema: custom; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE item_template_ferramenta (
    id integer NOT NULL,
    ordem smallint,
    tipo character varying(150),
    valor text,
    id_template_ferramenta integer
);


ALTER TABLE custom.item_template_ferramenta OWNER TO zioncloud3;

--
-- TOC entry 1637 (class 1259 OID 2839931)
-- Dependencies: 1636 8
-- Name: item_template_ferramenta_id_seq; Type: SEQUENCE; Schema: custom; Owner: zioncloud3
--

CREATE SEQUENCE item_template_ferramenta_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE custom.item_template_ferramenta_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2092 (class 0 OID 0)
-- Dependencies: 1637
-- Name: item_template_ferramenta_id_seq; Type: SEQUENCE OWNED BY; Schema: custom; Owner: zioncloud3
--

ALTER SEQUENCE item_template_ferramenta_id_seq OWNED BY item_template_ferramenta.id;


--
-- TOC entry 2093 (class 0 OID 0)
-- Dependencies: 1637
-- Name: item_template_ferramenta_id_seq; Type: SEQUENCE SET; Schema: custom; Owner: zioncloud3
--

SELECT pg_catalog.setval('item_template_ferramenta_id_seq', 1, false);


--
-- TOC entry 1638 (class 1259 OID 2839933)
-- Dependencies: 8
-- Name: item_template_newsletter; Type: TABLE; Schema: custom; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE item_template_newsletter (
    id integer NOT NULL,
    ordem smallint,
    id_tipo_item_newsletter integer,
    id_template_newsletter integer,
    valor text
);


ALTER TABLE custom.item_template_newsletter OWNER TO zioncloud3;

--
-- TOC entry 1639 (class 1259 OID 2839939)
-- Dependencies: 1638 8
-- Name: item_template_newsletter_id_seq; Type: SEQUENCE; Schema: custom; Owner: zioncloud3
--

CREATE SEQUENCE item_template_newsletter_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE custom.item_template_newsletter_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2095 (class 0 OID 0)
-- Dependencies: 1639
-- Name: item_template_newsletter_id_seq; Type: SEQUENCE OWNED BY; Schema: custom; Owner: zioncloud3
--

ALTER SEQUENCE item_template_newsletter_id_seq OWNED BY item_template_newsletter.id;


--
-- TOC entry 2096 (class 0 OID 0)
-- Dependencies: 1639
-- Name: item_template_newsletter_id_seq; Type: SEQUENCE SET; Schema: custom; Owner: zioncloud3
--

SELECT pg_catalog.setval('item_template_newsletter_id_seq', 1, false);


--
-- TOC entry 1640 (class 1259 OID 2839941)
-- Dependencies: 8
-- Name: template_ferramenta; Type: TABLE; Schema: custom; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE template_ferramenta (
    id integer NOT NULL,
    id_ferramenta integer,
    tipo character varying(150),
    obs text,
    id_modulo integer
);


ALTER TABLE custom.template_ferramenta OWNER TO zioncloud3;

--
-- TOC entry 1641 (class 1259 OID 2839947)
-- Dependencies: 1640 8
-- Name: template_ferramenta_id_seq; Type: SEQUENCE; Schema: custom; Owner: zioncloud3
--

CREATE SEQUENCE template_ferramenta_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE custom.template_ferramenta_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2097 (class 0 OID 0)
-- Dependencies: 1641
-- Name: template_ferramenta_id_seq; Type: SEQUENCE OWNED BY; Schema: custom; Owner: zioncloud3
--

ALTER SEQUENCE template_ferramenta_id_seq OWNED BY template_ferramenta.id;


--
-- TOC entry 2098 (class 0 OID 0)
-- Dependencies: 1641
-- Name: template_ferramenta_id_seq; Type: SEQUENCE SET; Schema: custom; Owner: zioncloud3
--

SELECT pg_catalog.setval('template_ferramenta_id_seq', 1, false);


--
-- TOC entry 1642 (class 1259 OID 2839949)
-- Dependencies: 8
-- Name: template_newsletter; Type: TABLE; Schema: custom; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE template_newsletter (
    id integer NOT NULL,
    nome character varying(300),
    descricao text,
    obs text,
    tipo character varying(30),
    id_ferramenta integer,
    id_modulo integer
);


ALTER TABLE custom.template_newsletter OWNER TO zioncloud3;

--
-- TOC entry 1643 (class 1259 OID 2839955)
-- Dependencies: 8 1642
-- Name: template_newsletter_id_seq; Type: SEQUENCE; Schema: custom; Owner: zioncloud3
--

CREATE SEQUENCE template_newsletter_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE custom.template_newsletter_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2100 (class 0 OID 0)
-- Dependencies: 1643
-- Name: template_newsletter_id_seq; Type: SEQUENCE OWNED BY; Schema: custom; Owner: zioncloud3
--

ALTER SEQUENCE template_newsletter_id_seq OWNED BY template_newsletter.id;


--
-- TOC entry 2101 (class 0 OID 0)
-- Dependencies: 1643
-- Name: template_newsletter_id_seq; Type: SEQUENCE SET; Schema: custom; Owner: zioncloud3
--

SELECT pg_catalog.setval('template_newsletter_id_seq', 1, false);


--
-- TOC entry 1644 (class 1259 OID 2839957)
-- Dependencies: 8
-- Name: tipo_item_newsletter; Type: TABLE; Schema: custom; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE tipo_item_newsletter (
    id integer NOT NULL,
    codigo character varying(30),
    nome character varying(300),
    imagem character varying(300),
    obs text
);


ALTER TABLE custom.tipo_item_newsletter OWNER TO zioncloud3;

--
-- TOC entry 1645 (class 1259 OID 2839963)
-- Dependencies: 8 1644
-- Name: tipo_item_newsletter_id_seq; Type: SEQUENCE; Schema: custom; Owner: zioncloud3
--

CREATE SEQUENCE tipo_item_newsletter_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE custom.tipo_item_newsletter_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2103 (class 0 OID 0)
-- Dependencies: 1645
-- Name: tipo_item_newsletter_id_seq; Type: SEQUENCE OWNED BY; Schema: custom; Owner: zioncloud3
--

ALTER SEQUENCE tipo_item_newsletter_id_seq OWNED BY tipo_item_newsletter.id;


--
-- TOC entry 2104 (class 0 OID 0)
-- Dependencies: 1645
-- Name: tipo_item_newsletter_id_seq; Type: SEQUENCE SET; Schema: custom; Owner: zioncloud3
--

SELECT pg_catalog.setval('tipo_item_newsletter_id_seq', 1, false);


--
-- TOC entry 1646 (class 1259 OID 2839965)
-- Dependencies: 8
-- Name: valor_item_template_newsletter; Type: TABLE; Schema: custom; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE valor_item_template_newsletter (
    id integer NOT NULL,
    chave character varying(300),
    valor text,
    id_item_template_newsletter integer
);


ALTER TABLE custom.valor_item_template_newsletter OWNER TO zioncloud3;

--
-- TOC entry 1647 (class 1259 OID 2839971)
-- Dependencies: 8 1646
-- Name: valor_item_template_newsletter_id_seq; Type: SEQUENCE; Schema: custom; Owner: zioncloud3
--

CREATE SEQUENCE valor_item_template_newsletter_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE custom.valor_item_template_newsletter_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2105 (class 0 OID 0)
-- Dependencies: 1647
-- Name: valor_item_template_newsletter_id_seq; Type: SEQUENCE OWNED BY; Schema: custom; Owner: zioncloud3
--

ALTER SEQUENCE valor_item_template_newsletter_id_seq OWNED BY valor_item_template_newsletter.id;


--
-- TOC entry 2106 (class 0 OID 0)
-- Dependencies: 1647
-- Name: valor_item_template_newsletter_id_seq; Type: SEQUENCE SET; Schema: custom; Owner: zioncloud3
--

SELECT pg_catalog.setval('valor_item_template_newsletter_id_seq', 1, false);


SET search_path = geral, pg_catalog;

--
-- TOC entry 1612 (class 1259 OID 2831079)
-- Dependencies: 7
-- Name: tb_estados; Type: TABLE; Schema: geral; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE tb_estados (
    id integer NOT NULL,
    uf character varying(10) NOT NULL,
    nome character varying(20) NOT NULL,
    regioes_id integer
);


ALTER TABLE geral.tb_estados OWNER TO zioncloud3;

--
-- TOC entry 1613 (class 1259 OID 2831082)
-- Dependencies: 7 1612
-- Name: tb_estados_id_seq; Type: SEQUENCE; Schema: geral; Owner: zioncloud3
--

CREATE SEQUENCE tb_estados_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE geral.tb_estados_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2107 (class 0 OID 0)
-- Dependencies: 1613
-- Name: tb_estados_id_seq; Type: SEQUENCE OWNED BY; Schema: geral; Owner: zioncloud3
--

ALTER SEQUENCE tb_estados_id_seq OWNED BY tb_estados.id;


--
-- TOC entry 2108 (class 0 OID 0)
-- Dependencies: 1613
-- Name: tb_estados_id_seq; Type: SEQUENCE SET; Schema: geral; Owner: zioncloud3
--

SELECT pg_catalog.setval('tb_estados_id_seq', 27, true);


SET search_path = public, pg_catalog;

--
-- TOC entry 1595 (class 1259 OID 2830888)
-- Dependencies: 6
-- Name: arquivo; Type: TABLE; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE arquivo (
    id integer NOT NULL,
    arquivo character varying(300),
    type character varying(100),
    id_tabela character varying(50),
    titulo character varying(300),
    tamanho numeric(18,2),
    id_registro integer,
    old_nome character varying(300),
    id_ticket integer
);


ALTER TABLE public.arquivo OWNER TO zioncloud3;

--
-- TOC entry 2109 (class 0 OID 0)
-- Dependencies: 1595
-- Name: COLUMN arquivo.tamanho; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN arquivo.tamanho IS 'Tamanho em bytes do arquivo.';


--
-- TOC entry 2110 (class 0 OID 0)
-- Dependencies: 1595
-- Name: COLUMN arquivo.id_registro; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN arquivo.id_registro IS 'Id do registro.';


--
-- TOC entry 1594 (class 1259 OID 2830886)
-- Dependencies: 1595 6
-- Name: arquivo_id_seq; Type: SEQUENCE; Schema: public; Owner: zioncloud3
--

CREATE SEQUENCE arquivo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.arquivo_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2111 (class 0 OID 0)
-- Dependencies: 1594
-- Name: arquivo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: zioncloud3
--

ALTER SEQUENCE arquivo_id_seq OWNED BY arquivo.id;


--
-- TOC entry 2112 (class 0 OID 0)
-- Dependencies: 1594
-- Name: arquivo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: zioncloud3
--

SELECT pg_catalog.setval('arquivo_id_seq', 1, false);


--
-- TOC entry 1617 (class 1259 OID 2831133)
-- Dependencies: 6
-- Name: associacao_cadastros; Type: TABLE; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE associacao_cadastros (
    id bigint NOT NULL,
    id_pai bigint,
    tabela_pai character varying(50),
    tipo_pai character varying(30),
    id_filho bigint,
    tabela_filho character varying(50),
    tipo_filho character varying(30),
    classificacao character varying(300)
);


ALTER TABLE public.associacao_cadastros OWNER TO zioncloud3;

--
-- TOC entry 2113 (class 0 OID 0)
-- Dependencies: 1617
-- Name: TABLE associacao_cadastros; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON TABLE associacao_cadastros IS 'Faz associação em vários cadastros do sistema';


--
-- TOC entry 2114 (class 0 OID 0)
-- Dependencies: 1617
-- Name: COLUMN associacao_cadastros.id; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN associacao_cadastros.id IS 'ID';


--
-- TOC entry 2115 (class 0 OID 0)
-- Dependencies: 1617
-- Name: COLUMN associacao_cadastros.id_pai; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN associacao_cadastros.id_pai IS 'Id do cadastro de pai';


--
-- TOC entry 2116 (class 0 OID 0)
-- Dependencies: 1617
-- Name: COLUMN associacao_cadastros.tabela_pai; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN associacao_cadastros.tabela_pai IS 'Nome da tabela, neste sistema, do registro pai';


--
-- TOC entry 2117 (class 0 OID 0)
-- Dependencies: 1617
-- Name: COLUMN associacao_cadastros.tipo_pai; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN associacao_cadastros.tipo_pai IS 'Forma de identificar o tipo de registro pai -> não obrigatório';


--
-- TOC entry 2118 (class 0 OID 0)
-- Dependencies: 1617
-- Name: COLUMN associacao_cadastros.id_filho; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN associacao_cadastros.id_filho IS 'Id do cadastro filho';


--
-- TOC entry 2119 (class 0 OID 0)
-- Dependencies: 1617
-- Name: COLUMN associacao_cadastros.tabela_filho; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN associacao_cadastros.tabela_filho IS 'Forma de identificar a tabela do registro filho';


--
-- TOC entry 2120 (class 0 OID 0)
-- Dependencies: 1617
-- Name: COLUMN associacao_cadastros.tipo_filho; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN associacao_cadastros.tipo_filho IS 'Forma de identificar o cadastro filho';


--
-- TOC entry 2121 (class 0 OID 0)
-- Dependencies: 1617
-- Name: COLUMN associacao_cadastros.classificacao; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN associacao_cadastros.classificacao IS 'Classificação do tipo de relacionamento';


--
-- TOC entry 1616 (class 1259 OID 2831131)
-- Dependencies: 1617 6
-- Name: associacao_cadastros_id_seq; Type: SEQUENCE; Schema: public; Owner: zioncloud3
--

CREATE SEQUENCE associacao_cadastros_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.associacao_cadastros_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2123 (class 0 OID 0)
-- Dependencies: 1616
-- Name: associacao_cadastros_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: zioncloud3
--

ALTER SEQUENCE associacao_cadastros_id_seq OWNED BY associacao_cadastros.id;


--
-- TOC entry 2124 (class 0 OID 0)
-- Dependencies: 1616
-- Name: associacao_cadastros_id_seq; Type: SEQUENCE SET; Schema: public; Owner: zioncloud3
--

SELECT pg_catalog.setval('associacao_cadastros_id_seq', 1, false);


--
-- TOC entry 1597 (class 1259 OID 2830901)
-- Dependencies: 6
-- Name: avaliacao_kappa; Type: TABLE; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE avaliacao_kappa (
    id integer NOT NULL,
    id_registro integer,
    nome_tabela character varying(100),
    id_componente_template integer,
    id_usuario integer,
    nota integer,
    ressalva text,
    data timestamp without time zone,
    id_ticket integer,
    id_avaliacao_kappa_pai integer,
    id_avaliacao_kappa_pai_usuario integer,
    id_usuario_avaliado integer,
    tipo_avaliacao character varying(50),
    contador integer,
    id_avaliacao_kappa_raiz integer
);


ALTER TABLE public.avaliacao_kappa OWNER TO zioncloud3;

--
-- TOC entry 1596 (class 1259 OID 2830899)
-- Dependencies: 1597 6
-- Name: avaliacao_kappa_id_seq; Type: SEQUENCE; Schema: public; Owner: zioncloud3
--

CREATE SEQUENCE avaliacao_kappa_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.avaliacao_kappa_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2125 (class 0 OID 0)
-- Dependencies: 1596
-- Name: avaliacao_kappa_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: zioncloud3
--

ALTER SEQUENCE avaliacao_kappa_id_seq OWNED BY avaliacao_kappa.id;


--
-- TOC entry 2126 (class 0 OID 0)
-- Dependencies: 1596
-- Name: avaliacao_kappa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: zioncloud3
--

SELECT pg_catalog.setval('avaliacao_kappa_id_seq', 2, true);


--
-- TOC entry 1609 (class 1259 OID 2831060)
-- Dependencies: 6
-- Name: cadastro_basico; Type: TABLE; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE cadastro_basico (
    id integer NOT NULL,
    descricao character varying(300),
    id_tipo_cadastro_basico integer,
    campo1 character varying(30),
    campo2 character varying(30),
    campo3 character varying(300),
    codigo character varying(50)
);


ALTER TABLE public.cadastro_basico OWNER TO zioncloud3;

--
-- TOC entry 2127 (class 0 OID 0)
-- Dependencies: 1609
-- Name: COLUMN cadastro_basico.id; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN cadastro_basico.id IS 'ID';


--
-- TOC entry 2128 (class 0 OID 0)
-- Dependencies: 1609
-- Name: COLUMN cadastro_basico.descricao; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN cadastro_basico.descricao IS 'Descrição';


--
-- TOC entry 1608 (class 1259 OID 2831058)
-- Dependencies: 6 1609
-- Name: cadastro_basico_id_seq; Type: SEQUENCE; Schema: public; Owner: zioncloud3
--

CREATE SEQUENCE cadastro_basico_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cadastro_basico_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2130 (class 0 OID 0)
-- Dependencies: 1608
-- Name: cadastro_basico_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: zioncloud3
--

ALTER SEQUENCE cadastro_basico_id_seq OWNED BY cadastro_basico.id;


--
-- TOC entry 2131 (class 0 OID 0)
-- Dependencies: 1608
-- Name: cadastro_basico_id_seq; Type: SEQUENCE SET; Schema: public; Owner: zioncloud3
--

SELECT pg_catalog.setval('cadastro_basico_id_seq', 4, true);


--
-- TOC entry 1621 (class 1259 OID 2839602)
-- Dependencies: 6
-- Name: chat_ticket; Type: TABLE; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE chat_ticket (
    id bigint NOT NULL,
    data timestamp without time zone,
    id_ticket integer,
    ultima_interacao timestamp without time zone,
    status character varying(100),
    ultima_mensagem text,
    ultimo_lido timestamp without time zone,
    ids_usuarios text
);


ALTER TABLE public.chat_ticket OWNER TO zioncloud3;

--
-- TOC entry 1620 (class 1259 OID 2839600)
-- Dependencies: 6 1621
-- Name: chat_ticket_id_seq; Type: SEQUENCE; Schema: public; Owner: zioncloud3
--

CREATE SEQUENCE chat_ticket_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.chat_ticket_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2132 (class 0 OID 0)
-- Dependencies: 1620
-- Name: chat_ticket_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: zioncloud3
--

ALTER SEQUENCE chat_ticket_id_seq OWNED BY chat_ticket.id;


--
-- TOC entry 2133 (class 0 OID 0)
-- Dependencies: 1620
-- Name: chat_ticket_id_seq; Type: SEQUENCE SET; Schema: public; Owner: zioncloud3
--

SELECT pg_catalog.setval('chat_ticket_id_seq', 1, true);


--
-- TOC entry 1623 (class 1259 OID 2839615)
-- Dependencies: 1941 6
-- Name: chat_ticket_mensagem; Type: TABLE; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE chat_ticket_mensagem (
    id bigint NOT NULL,
    id_usuario integer,
    id_ticket integer,
    id_chat integer,
    data timestamp without time zone,
    mensagem text,
    lido smallint DEFAULT 0,
    data_lido timestamp without time zone
);


ALTER TABLE public.chat_ticket_mensagem OWNER TO zioncloud3;

--
-- TOC entry 1622 (class 1259 OID 2839613)
-- Dependencies: 6 1623
-- Name: chat_ticket_mensagem_id_seq; Type: SEQUENCE; Schema: public; Owner: zioncloud3
--

CREATE SEQUENCE chat_ticket_mensagem_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.chat_ticket_mensagem_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2134 (class 0 OID 0)
-- Dependencies: 1622
-- Name: chat_ticket_mensagem_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: zioncloud3
--

ALTER SEQUENCE chat_ticket_mensagem_id_seq OWNED BY chat_ticket_mensagem.id;


--
-- TOC entry 2135 (class 0 OID 0)
-- Dependencies: 1622
-- Name: chat_ticket_mensagem_id_seq; Type: SEQUENCE SET; Schema: public; Owner: zioncloud3
--

SELECT pg_catalog.setval('chat_ticket_mensagem_id_seq', 27, true);


--
-- TOC entry 1625 (class 1259 OID 2839632)
-- Dependencies: 1943 6
-- Name: chat_ticket_mensagem_status; Type: TABLE; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE chat_ticket_mensagem_status (
    id bigint NOT NULL,
    id_mensagem integer,
    id_usuario integer,
    lido smallint DEFAULT 0,
    id_chat integer,
    data_lido timestamp without time zone
);


ALTER TABLE public.chat_ticket_mensagem_status OWNER TO zioncloud3;

--
-- TOC entry 1624 (class 1259 OID 2839630)
-- Dependencies: 1625 6
-- Name: chat_ticket_mensagem_status_id_seq; Type: SEQUENCE; Schema: public; Owner: zioncloud3
--

CREATE SEQUENCE chat_ticket_mensagem_status_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.chat_ticket_mensagem_status_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2136 (class 0 OID 0)
-- Dependencies: 1624
-- Name: chat_ticket_mensagem_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: zioncloud3
--

ALTER SEQUENCE chat_ticket_mensagem_status_id_seq OWNED BY chat_ticket_mensagem_status.id;


--
-- TOC entry 2137 (class 0 OID 0)
-- Dependencies: 1624
-- Name: chat_ticket_mensagem_status_id_seq; Type: SEQUENCE SET; Schema: public; Owner: zioncloud3
--

SELECT pg_catalog.setval('chat_ticket_mensagem_status_id_seq', 54, true);


--
-- TOC entry 1627 (class 1259 OID 2839644)
-- Dependencies: 6
-- Name: chat_ticket_participante; Type: TABLE; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE chat_ticket_participante (
    id bigint NOT NULL,
    id_usuario integer,
    id_ticket integer,
    id_chat integer,
    ultima_interacao timestamp without time zone,
    ultima_mensagem text,
    data timestamp without time zone
);


ALTER TABLE public.chat_ticket_participante OWNER TO zioncloud3;

--
-- TOC entry 1626 (class 1259 OID 2839642)
-- Dependencies: 1627 6
-- Name: chat_ticket_participante_id_seq; Type: SEQUENCE; Schema: public; Owner: zioncloud3
--

CREATE SEQUENCE chat_ticket_participante_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.chat_ticket_participante_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2138 (class 0 OID 0)
-- Dependencies: 1626
-- Name: chat_ticket_participante_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: zioncloud3
--

ALTER SEQUENCE chat_ticket_participante_id_seq OWNED BY chat_ticket_participante.id;


--
-- TOC entry 2139 (class 0 OID 0)
-- Dependencies: 1626
-- Name: chat_ticket_participante_id_seq; Type: SEQUENCE SET; Schema: public; Owner: zioncloud3
--

SELECT pg_catalog.setval('chat_ticket_participante_id_seq', 2, true);


--
-- TOC entry 1599 (class 1259 OID 2830917)
-- Dependencies: 1928 6
-- Name: log; Type: TABLE; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE log (
    id bigint NOT NULL,
    acao integer,
    id_registro integer,
    tabela character varying(30),
    conteudo text,
    data timestamp without time zone,
    id_usuario integer,
    usuario character varying(300),
    criterio character varying(1000),
    email_destino character varying(300),
    eh_email numeric(3,0) DEFAULT 0
);


ALTER TABLE public.log OWNER TO zioncloud3;

--
-- TOC entry 2140 (class 0 OID 0)
-- Dependencies: 1599
-- Name: COLUMN log.id; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN log.id IS 'ID';


--
-- TOC entry 2141 (class 0 OID 0)
-- Dependencies: 1599
-- Name: COLUMN log.tabela; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN log.tabela IS 'Tabela';


--
-- TOC entry 2142 (class 0 OID 0)
-- Dependencies: 1599
-- Name: COLUMN log.conteudo; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN log.conteudo IS 'Conteúdo em XML';


--
-- TOC entry 2143 (class 0 OID 0)
-- Dependencies: 1599
-- Name: COLUMN log.data; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN log.data IS 'Data da Fatura';


--
-- TOC entry 1598 (class 1259 OID 2830915)
-- Dependencies: 1599 6
-- Name: log_id_seq; Type: SEQUENCE; Schema: public; Owner: zioncloud3
--

CREATE SEQUENCE log_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.log_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2144 (class 0 OID 0)
-- Dependencies: 1598
-- Name: log_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: zioncloud3
--

ALTER SEQUENCE log_id_seq OWNED BY log.id;


--
-- TOC entry 2145 (class 0 OID 0)
-- Dependencies: 1598
-- Name: log_id_seq; Type: SEQUENCE SET; Schema: public; Owner: zioncloud3
--

SELECT pg_catalog.setval('log_id_seq', 1, false);


--
-- TOC entry 1615 (class 1259 OID 2831103)
-- Dependencies: 6
-- Name: marcacao; Type: TABLE; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE marcacao (
    id integer NOT NULL,
    tipo character varying(100),
    titulo character varying(300),
    texto text,
    municipio character varying(300),
    id_municipio integer,
    imagem character varying(300),
    localizacao character varying(300),
    url_livro character varying(300),
    coordenadas character varying(100),
    coord_x numeric(18,2),
    coord_y numeric(18,2),
    data_cadastro timestamp without time zone,
    id_usuario integer,
    usuario_cadastro character varying(300),
    status character varying(10),
    leaf_lat numeric(18,2),
    leaf_lng numeric(18,2),
    id_tipo_marcacao integer
);


ALTER TABLE public.marcacao OWNER TO zioncloud3;

--
-- TOC entry 1614 (class 1259 OID 2831101)
-- Dependencies: 6 1615
-- Name: marcacao_id_seq; Type: SEQUENCE; Schema: public; Owner: zioncloud3
--

CREATE SEQUENCE marcacao_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.marcacao_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2146 (class 0 OID 0)
-- Dependencies: 1614
-- Name: marcacao_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: zioncloud3
--

ALTER SEQUENCE marcacao_id_seq OWNED BY marcacao.id;


--
-- TOC entry 2147 (class 0 OID 0)
-- Dependencies: 1614
-- Name: marcacao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: zioncloud3
--

SELECT pg_catalog.setval('marcacao_id_seq', 6, true);


--
-- TOC entry 1619 (class 1259 OID 2831142)
-- Dependencies: 6
-- Name: marcacao_tipo; Type: TABLE; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE marcacao_tipo (
    id integer NOT NULL,
    nome character varying(300),
    imagem character varying(300),
    status character varying(30)
);


ALTER TABLE public.marcacao_tipo OWNER TO zioncloud3;

--
-- TOC entry 2148 (class 0 OID 0)
-- Dependencies: 1619
-- Name: COLUMN marcacao_tipo.id; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN marcacao_tipo.id IS 'ID';


--
-- TOC entry 2149 (class 0 OID 0)
-- Dependencies: 1619
-- Name: COLUMN marcacao_tipo.nome; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN marcacao_tipo.nome IS 'Nome';


--
-- TOC entry 2150 (class 0 OID 0)
-- Dependencies: 1619
-- Name: COLUMN marcacao_tipo.imagem; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN marcacao_tipo.imagem IS 'Imagem';


--
-- TOC entry 1618 (class 1259 OID 2831140)
-- Dependencies: 1619 6
-- Name: marcacao_tipo_id_seq; Type: SEQUENCE; Schema: public; Owner: zioncloud3
--

CREATE SEQUENCE marcacao_tipo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.marcacao_tipo_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2152 (class 0 OID 0)
-- Dependencies: 1618
-- Name: marcacao_tipo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: zioncloud3
--

ALTER SEQUENCE marcacao_tipo_id_seq OWNED BY marcacao_tipo.id;


--
-- TOC entry 2153 (class 0 OID 0)
-- Dependencies: 1618
-- Name: marcacao_tipo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: zioncloud3
--

SELECT pg_catalog.setval('marcacao_tipo_id_seq', 3, true);


--
-- TOC entry 1601 (class 1259 OID 2830931)
-- Dependencies: 6
-- Name: parameters; Type: TABLE; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE parameters (
    id integer NOT NULL,
    code character varying(100),
    value character varying(300),
    title character varying(300)
);


ALTER TABLE public.parameters OWNER TO zioncloud3;

--
-- TOC entry 2154 (class 0 OID 0)
-- Dependencies: 1601
-- Name: TABLE parameters; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON TABLE parameters IS 'Application parameters';


--
-- TOC entry 2155 (class 0 OID 0)
-- Dependencies: 1601
-- Name: COLUMN parameters.id; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN parameters.id IS 'ID';


--
-- TOC entry 2156 (class 0 OID 0)
-- Dependencies: 1601
-- Name: COLUMN parameters.code; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN parameters.code IS 'Parameter Code';


--
-- TOC entry 2157 (class 0 OID 0)
-- Dependencies: 1601
-- Name: COLUMN parameters.value; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN parameters.value IS 'Parameter Value';


--
-- TOC entry 2158 (class 0 OID 0)
-- Dependencies: 1601
-- Name: COLUMN parameters.title; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN parameters.title IS 'Parameter Title';


--
-- TOC entry 1600 (class 1259 OID 2830929)
-- Dependencies: 1601 6
-- Name: parameters_id_seq; Type: SEQUENCE; Schema: public; Owner: zioncloud3
--

CREATE SEQUENCE parameters_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.parameters_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2159 (class 0 OID 0)
-- Dependencies: 1600
-- Name: parameters_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: zioncloud3
--

ALTER SEQUENCE parameters_id_seq OWNED BY parameters.id;


--
-- TOC entry 2160 (class 0 OID 0)
-- Dependencies: 1600
-- Name: parameters_id_seq; Type: SEQUENCE SET; Schema: public; Owner: zioncloud3
--

SELECT pg_catalog.setval('parameters_id_seq', 1, false);


--
-- TOC entry 1611 (class 1259 OID 2831072)
-- Dependencies: 6
-- Name: tipo_cadastro_basico; Type: TABLE; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE tipo_cadastro_basico (
    id integer NOT NULL,
    descricao character varying(300)
);


ALTER TABLE public.tipo_cadastro_basico OWNER TO zioncloud3;

--
-- TOC entry 2161 (class 0 OID 0)
-- Dependencies: 1611
-- Name: COLUMN tipo_cadastro_basico.id; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN tipo_cadastro_basico.id IS 'ID';


--
-- TOC entry 2162 (class 0 OID 0)
-- Dependencies: 1611
-- Name: COLUMN tipo_cadastro_basico.descricao; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN tipo_cadastro_basico.descricao IS 'Descrição do tipo de cadastro básico';


--
-- TOC entry 1610 (class 1259 OID 2831070)
-- Dependencies: 6 1611
-- Name: tipo_cadastro_basico_id_seq; Type: SEQUENCE; Schema: public; Owner: zioncloud3
--

CREATE SEQUENCE tipo_cadastro_basico_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_cadastro_basico_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2164 (class 0 OID 0)
-- Dependencies: 1610
-- Name: tipo_cadastro_basico_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: zioncloud3
--

ALTER SEQUENCE tipo_cadastro_basico_id_seq OWNED BY tipo_cadastro_basico.id;


--
-- TOC entry 2165 (class 0 OID 0)
-- Dependencies: 1610
-- Name: tipo_cadastro_basico_id_seq; Type: SEQUENCE SET; Schema: public; Owner: zioncloud3
--

SELECT pg_catalog.setval('tipo_cadastro_basico_id_seq', 2, true);


--
-- TOC entry 1603 (class 1259 OID 2830942)
-- Dependencies: 6
-- Name: usuario; Type: TABLE; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE usuario (
    id integer NOT NULL,
    nome character varying(300),
    sobrenome character varying(300),
    nome_completo character varying(300),
    data_cadastro timestamp without time zone,
    email character varying(300),
    email2 character varying(300),
    imagem character varying(300),
    identificacao_facebook character varying(350),
    identificacao_twitter character varying(350),
    identificacao_microsoft character varying(350),
    identificacao_google character varying(350),
    cpf character varying(30),
    rg character varying(30),
    telefone character varying(30),
    telefone2 character varying(30),
    verificado_email smallint,
    verificado_senha smallint,
    codigo_verificacao character varying(50),
    senha character varying(300),
    endereco text,
    id_municipio integer,
    municipio character varying(300),
    uf character varying(2),
    obs text,
    metadados text,
    perfil integer,
    auto_descricao text,
    genero character varying(300),
    edtr_educacao character varying(300),
    edtr_profissao character varying(300),
    edtr_empresa character varying(300),
    fuso_horario character varying(30),
    contato_seguranca character varying(300),
    pais character varying(50),
    data_nascimento timestamp without time zone,
    bairro character varying(100),
    cep character varying(14),
    origem_cadastro character varying(40),
    sexo character varying(8),
    perfil_acesso character varying(30),
    aceitou_termo smallint,
    status_aprovacao smallint,
    vi_tour_protag character varying(1)
);


ALTER TABLE public.usuario OWNER TO zioncloud3;

--
-- TOC entry 2166 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.nome; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.nome IS 'Nome';


--
-- TOC entry 2167 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.sobrenome; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.sobrenome IS 'Sobrenome';


--
-- TOC entry 2168 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.nome_completo; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.nome_completo IS 'Nome Completo';


--
-- TOC entry 2169 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.data_cadastro; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.data_cadastro IS 'Data de Cadastro';


--
-- TOC entry 2170 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.email; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.email IS 'Email';


--
-- TOC entry 2171 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.email2; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.email2 IS 'Email alternativo';


--
-- TOC entry 2172 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.imagem; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.imagem IS 'Arquivo de imagem (ou gravatar)';


--
-- TOC entry 2173 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.identificacao_facebook; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.identificacao_facebook IS 'Identificação - Perfil Facebook';


--
-- TOC entry 2174 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.identificacao_twitter; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.identificacao_twitter IS 'Identificação - Perfil Twitter';


--
-- TOC entry 2175 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.identificacao_microsoft; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.identificacao_microsoft IS 'Identificação - Perfil Microsoft';


--
-- TOC entry 2176 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.identificacao_google; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.identificacao_google IS 'Identificação - Perfil Google';


--
-- TOC entry 2177 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.cpf; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.cpf IS 'CPF';


--
-- TOC entry 2178 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.rg; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.rg IS 'RG';


--
-- TOC entry 2179 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.telefone; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.telefone IS 'Telefone';


--
-- TOC entry 2180 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.telefone2; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.telefone2 IS 'Telefone 2';


--
-- TOC entry 2181 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.verificado_email; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.verificado_email IS 'Verificado Email';


--
-- TOC entry 2182 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.verificado_senha; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.verificado_senha IS 'Senha verificada / Criada';


--
-- TOC entry 2183 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.codigo_verificacao; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.codigo_verificacao IS 'Codigo Verificacao';


--
-- TOC entry 2184 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.senha; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.senha IS 'Senha encriptada';


--
-- TOC entry 2185 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.endereco; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.endereco IS 'Endereço';


--
-- TOC entry 2186 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.id_municipio; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.id_municipio IS 'Município';


--
-- TOC entry 2187 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.municipio; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.municipio IS 'Nome do município';


--
-- TOC entry 2188 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.uf; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.uf IS 'UF';


--
-- TOC entry 2189 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.obs; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.obs IS 'Observações';


--
-- TOC entry 2190 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.metadados; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.metadados IS 'MetaDados - RedeSocial';


--
-- TOC entry 2191 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.auto_descricao; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.auto_descricao IS 'Descreva-se';


--
-- TOC entry 2192 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.genero; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.genero IS 'Auto definição de gênero';


--
-- TOC entry 2193 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.edtr_educacao; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.edtr_educacao IS 'Educação';


--
-- TOC entry 2194 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.edtr_profissao; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.edtr_profissao IS 'Profissão';


--
-- TOC entry 2195 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.edtr_empresa; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.edtr_empresa IS 'Empresa que Trabalha';


--
-- TOC entry 2196 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.fuso_horario; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.fuso_horario IS 'Fuso HOrário';


--
-- TOC entry 2197 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.contato_seguranca; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.contato_seguranca IS 'Contato Seguranca';


--
-- TOC entry 2198 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.pais; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.pais IS 'País';


--
-- TOC entry 2199 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.data_nascimento; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.data_nascimento IS 'Data de Nascimento';


--
-- TOC entry 2200 (class 0 OID 0)
-- Dependencies: 1603
-- Name: COLUMN usuario.bairro; Type: COMMENT; Schema: public; Owner: zioncloud3
--

COMMENT ON COLUMN usuario.bairro IS 'CEP';


--
-- TOC entry 1605 (class 1259 OID 2830953)
-- Dependencies: 6
-- Name: usuario_dado; Type: TABLE; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE usuario_dado (
    id integer NOT NULL,
    texto text,
    tipo character varying(20),
    id_usuario integer,
    status smallint
);


ALTER TABLE public.usuario_dado OWNER TO zioncloud3;

--
-- TOC entry 1604 (class 1259 OID 2830951)
-- Dependencies: 1605 6
-- Name: usuario_dado_id_seq; Type: SEQUENCE; Schema: public; Owner: zioncloud3
--

CREATE SEQUENCE usuario_dado_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuario_dado_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2201 (class 0 OID 0)
-- Dependencies: 1604
-- Name: usuario_dado_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: zioncloud3
--

ALTER SEQUENCE usuario_dado_id_seq OWNED BY usuario_dado.id;


--
-- TOC entry 2202 (class 0 OID 0)
-- Dependencies: 1604
-- Name: usuario_dado_id_seq; Type: SEQUENCE SET; Schema: public; Owner: zioncloud3
--

SELECT pg_catalog.setval('usuario_dado_id_seq', 1, false);


--
-- TOC entry 1602 (class 1259 OID 2830940)
-- Dependencies: 6 1603
-- Name: usuario_id_seq; Type: SEQUENCE; Schema: public; Owner: zioncloud3
--

CREATE SEQUENCE usuario_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuario_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2203 (class 0 OID 0)
-- Dependencies: 1602
-- Name: usuario_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: zioncloud3
--

ALTER SEQUENCE usuario_id_seq OWNED BY usuario.id;


--
-- TOC entry 2204 (class 0 OID 0)
-- Dependencies: 1602
-- Name: usuario_id_seq; Type: SEQUENCE SET; Schema: public; Owner: zioncloud3
--

SELECT pg_catalog.setval('usuario_id_seq', 4, true);


--
-- TOC entry 1607 (class 1259 OID 2830964)
-- Dependencies: 6
-- Name: usuario_imagem; Type: TABLE; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE TABLE usuario_imagem (
    id integer NOT NULL,
    imagem character varying(300),
    tipo character varying(20),
    id_usuario integer,
    status smallint
);


ALTER TABLE public.usuario_imagem OWNER TO zioncloud3;

--
-- TOC entry 1606 (class 1259 OID 2830962)
-- Dependencies: 6 1607
-- Name: usuario_imagem_id_seq; Type: SEQUENCE; Schema: public; Owner: zioncloud3
--

CREATE SEQUENCE usuario_imagem_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuario_imagem_id_seq OWNER TO zioncloud3;

--
-- TOC entry 2205 (class 0 OID 0)
-- Dependencies: 1606
-- Name: usuario_imagem_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: zioncloud3
--

ALTER SEQUENCE usuario_imagem_id_seq OWNED BY usuario_imagem.id;


--
-- TOC entry 2206 (class 0 OID 0)
-- Dependencies: 1606
-- Name: usuario_imagem_id_seq; Type: SEQUENCE SET; Schema: public; Owner: zioncloud3
--

SELECT pg_catalog.setval('usuario_imagem_id_seq', 6, true);


SET search_path = custom, pg_catalog;

--
-- TOC entry 1945 (class 2604 OID 2839973)
-- Dependencies: 1629 1628
-- Name: id; Type: DEFAULT; Schema: custom; Owner: zioncloud3
--

ALTER TABLE componente_template ALTER COLUMN id SET DEFAULT nextval('componente_template_id_seq'::regclass);


--
-- TOC entry 1946 (class 2604 OID 2839974)
-- Dependencies: 1631 1630
-- Name: id; Type: DEFAULT; Schema: custom; Owner: zioncloud3
--

ALTER TABLE componente_template_item ALTER COLUMN id SET DEFAULT nextval('componente_template_item_id_seq'::regclass);


--
-- TOC entry 1947 (class 2604 OID 2839975)
-- Dependencies: 1633 1632
-- Name: id; Type: DEFAULT; Schema: custom; Owner: zioncloud3
--

ALTER TABLE grupo_componente_template ALTER COLUMN id SET DEFAULT nextval('grupo_componente_template_id_seq'::regclass);


--
-- TOC entry 1948 (class 2604 OID 2839976)
-- Dependencies: 1635 1634
-- Name: id; Type: DEFAULT; Schema: custom; Owner: zioncloud3
--

ALTER TABLE item_componente ALTER COLUMN id SET DEFAULT nextval('item_componente_id_seq'::regclass);


--
-- TOC entry 1949 (class 2604 OID 2839977)
-- Dependencies: 1637 1636
-- Name: id; Type: DEFAULT; Schema: custom; Owner: zioncloud3
--

ALTER TABLE item_template_ferramenta ALTER COLUMN id SET DEFAULT nextval('item_template_ferramenta_id_seq'::regclass);


--
-- TOC entry 1950 (class 2604 OID 2839978)
-- Dependencies: 1639 1638
-- Name: id; Type: DEFAULT; Schema: custom; Owner: zioncloud3
--

ALTER TABLE item_template_newsletter ALTER COLUMN id SET DEFAULT nextval('item_template_newsletter_id_seq'::regclass);


--
-- TOC entry 1951 (class 2604 OID 2839979)
-- Dependencies: 1641 1640
-- Name: id; Type: DEFAULT; Schema: custom; Owner: zioncloud3
--

ALTER TABLE template_ferramenta ALTER COLUMN id SET DEFAULT nextval('template_ferramenta_id_seq'::regclass);


--
-- TOC entry 1952 (class 2604 OID 2839980)
-- Dependencies: 1643 1642
-- Name: id; Type: DEFAULT; Schema: custom; Owner: zioncloud3
--

ALTER TABLE template_newsletter ALTER COLUMN id SET DEFAULT nextval('template_newsletter_id_seq'::regclass);


--
-- TOC entry 1953 (class 2604 OID 2839981)
-- Dependencies: 1645 1644
-- Name: id; Type: DEFAULT; Schema: custom; Owner: zioncloud3
--

ALTER TABLE tipo_item_newsletter ALTER COLUMN id SET DEFAULT nextval('tipo_item_newsletter_id_seq'::regclass);


--
-- TOC entry 1954 (class 2604 OID 2839982)
-- Dependencies: 1647 1646
-- Name: id; Type: DEFAULT; Schema: custom; Owner: zioncloud3
--

ALTER TABLE valor_item_template_newsletter ALTER COLUMN id SET DEFAULT nextval('valor_item_template_newsletter_id_seq'::regclass);


SET search_path = geral, pg_catalog;

--
-- TOC entry 1935 (class 2604 OID 2831084)
-- Dependencies: 1613 1612
-- Name: id; Type: DEFAULT; Schema: geral; Owner: zioncloud3
--

ALTER TABLE tb_estados ALTER COLUMN id SET DEFAULT nextval('tb_estados_id_seq'::regclass);


SET search_path = public, pg_catalog;

--
-- TOC entry 1925 (class 2604 OID 2830891)
-- Dependencies: 1594 1595 1595
-- Name: id; Type: DEFAULT; Schema: public; Owner: zioncloud3
--

ALTER TABLE arquivo ALTER COLUMN id SET DEFAULT nextval('arquivo_id_seq'::regclass);


--
-- TOC entry 1937 (class 2604 OID 2831136)
-- Dependencies: 1617 1616 1617
-- Name: id; Type: DEFAULT; Schema: public; Owner: zioncloud3
--

ALTER TABLE associacao_cadastros ALTER COLUMN id SET DEFAULT nextval('associacao_cadastros_id_seq'::regclass);


--
-- TOC entry 1926 (class 2604 OID 2830904)
-- Dependencies: 1597 1596 1597
-- Name: id; Type: DEFAULT; Schema: public; Owner: zioncloud3
--

ALTER TABLE avaliacao_kappa ALTER COLUMN id SET DEFAULT nextval('avaliacao_kappa_id_seq'::regclass);


--
-- TOC entry 1933 (class 2604 OID 2831063)
-- Dependencies: 1609 1608 1609
-- Name: id; Type: DEFAULT; Schema: public; Owner: zioncloud3
--

ALTER TABLE cadastro_basico ALTER COLUMN id SET DEFAULT nextval('cadastro_basico_id_seq'::regclass);


--
-- TOC entry 1939 (class 2604 OID 2839605)
-- Dependencies: 1620 1621 1621
-- Name: id; Type: DEFAULT; Schema: public; Owner: zioncloud3
--

ALTER TABLE chat_ticket ALTER COLUMN id SET DEFAULT nextval('chat_ticket_id_seq'::regclass);


--
-- TOC entry 1940 (class 2604 OID 2839618)
-- Dependencies: 1622 1623 1623
-- Name: id; Type: DEFAULT; Schema: public; Owner: zioncloud3
--

ALTER TABLE chat_ticket_mensagem ALTER COLUMN id SET DEFAULT nextval('chat_ticket_mensagem_id_seq'::regclass);


--
-- TOC entry 1942 (class 2604 OID 2839635)
-- Dependencies: 1624 1625 1625
-- Name: id; Type: DEFAULT; Schema: public; Owner: zioncloud3
--

ALTER TABLE chat_ticket_mensagem_status ALTER COLUMN id SET DEFAULT nextval('chat_ticket_mensagem_status_id_seq'::regclass);


--
-- TOC entry 1944 (class 2604 OID 2839647)
-- Dependencies: 1626 1627 1627
-- Name: id; Type: DEFAULT; Schema: public; Owner: zioncloud3
--

ALTER TABLE chat_ticket_participante ALTER COLUMN id SET DEFAULT nextval('chat_ticket_participante_id_seq'::regclass);


--
-- TOC entry 1927 (class 2604 OID 2830920)
-- Dependencies: 1599 1598 1599
-- Name: id; Type: DEFAULT; Schema: public; Owner: zioncloud3
--

ALTER TABLE log ALTER COLUMN id SET DEFAULT nextval('log_id_seq'::regclass);


--
-- TOC entry 1936 (class 2604 OID 2831106)
-- Dependencies: 1614 1615 1615
-- Name: id; Type: DEFAULT; Schema: public; Owner: zioncloud3
--

ALTER TABLE marcacao ALTER COLUMN id SET DEFAULT nextval('marcacao_id_seq'::regclass);


--
-- TOC entry 1938 (class 2604 OID 2831145)
-- Dependencies: 1619 1618 1619
-- Name: id; Type: DEFAULT; Schema: public; Owner: zioncloud3
--

ALTER TABLE marcacao_tipo ALTER COLUMN id SET DEFAULT nextval('marcacao_tipo_id_seq'::regclass);


--
-- TOC entry 1929 (class 2604 OID 2830934)
-- Dependencies: 1601 1600 1601
-- Name: id; Type: DEFAULT; Schema: public; Owner: zioncloud3
--

ALTER TABLE parameters ALTER COLUMN id SET DEFAULT nextval('parameters_id_seq'::regclass);


--
-- TOC entry 1934 (class 2604 OID 2831075)
-- Dependencies: 1610 1611 1611
-- Name: id; Type: DEFAULT; Schema: public; Owner: zioncloud3
--

ALTER TABLE tipo_cadastro_basico ALTER COLUMN id SET DEFAULT nextval('tipo_cadastro_basico_id_seq'::regclass);


--
-- TOC entry 1930 (class 2604 OID 2830945)
-- Dependencies: 1602 1603 1603
-- Name: id; Type: DEFAULT; Schema: public; Owner: zioncloud3
--

ALTER TABLE usuario ALTER COLUMN id SET DEFAULT nextval('usuario_id_seq'::regclass);


--
-- TOC entry 1931 (class 2604 OID 2830956)
-- Dependencies: 1605 1604 1605
-- Name: id; Type: DEFAULT; Schema: public; Owner: zioncloud3
--

ALTER TABLE usuario_dado ALTER COLUMN id SET DEFAULT nextval('usuario_dado_id_seq'::regclass);


--
-- TOC entry 1932 (class 2604 OID 2830967)
-- Dependencies: 1607 1606 1607
-- Name: id; Type: DEFAULT; Schema: public; Owner: zioncloud3
--

ALTER TABLE usuario_imagem ALTER COLUMN id SET DEFAULT nextval('usuario_imagem_id_seq'::regclass);


SET search_path = custom, pg_catalog;

--
-- TOC entry 2065 (class 0 OID 2839893)
-- Dependencies: 1628
-- Data for Name: componente_template; Type: TABLE DATA; Schema: custom; Owner: zioncloud3
--



--
-- TOC entry 2066 (class 0 OID 2839901)
-- Dependencies: 1630
-- Data for Name: componente_template_item; Type: TABLE DATA; Schema: custom; Owner: zioncloud3
--



--
-- TOC entry 2067 (class 0 OID 2839909)
-- Dependencies: 1632
-- Data for Name: grupo_componente_template; Type: TABLE DATA; Schema: custom; Owner: zioncloud3
--



--
-- TOC entry 2068 (class 0 OID 2839917)
-- Dependencies: 1634
-- Data for Name: item_componente; Type: TABLE DATA; Schema: custom; Owner: zioncloud3
--

INSERT INTO item_componente (id, codigo, nome, imagem, imagem_miniatura, obs, status) VALUES (3, 'VIDEO', 'Vídeo', '547634b3a0631.png', '547634b3a0631_mini.png', 'Testes', NULL);
INSERT INTO item_componente (id, codigo, nome, imagem, imagem_miniatura, obs, status) VALUES (2, 'REL', 'Relacionamento entre componentes', '547634d7d1eff.png', '547634d7d1eff_mini.png', 'Relacionamento', NULL);
INSERT INTO item_componente (id, codigo, nome, imagem, imagem_miniatura, obs, status) VALUES (24, 'IMAGEM', 'Imagem', '547635b6b814b.png', '547635b6b814b_mini.png', NULL, NULL);
INSERT INTO item_componente (id, codigo, nome, imagem, imagem_miniatura, obs, status) VALUES (23, 'INPUT-TEXT', 'Campo de entrada de texto (usuário digita)', '547635d8b63c8.png', '547635d8b63c8_mini.png', NULL, NULL);
INSERT INTO item_componente (id, codigo, nome, imagem, imagem_miniatura, obs, status) VALUES (4, 'TEXTO', 'Texto (Label de Título)', '54764e5c8764a.png', '54764e5c8764a_mini.png', 'Texto de tamanho maior (Título)', NULL);
INSERT INTO item_componente (id, codigo, nome, imagem, imagem_miniatura, obs, status) VALUES (1, 'TEXTO-M', 'Texto Menor (Label de menor tamanho)', '54764fd73da5d.png', '54764fd73da5d_mini.png', 'Texto de menor tamanho', NULL);
INSERT INTO item_componente (id, codigo, nome, imagem, imagem_miniatura, obs, status) VALUES (26, 'TEXTO-P', 'Texto Parágrafo', '5591bf63a6007.png', '5591bf63a6007_mini.png', 'Texto de parágrafo.', NULL);
INSERT INTO item_componente (id, codigo, nome, imagem, imagem_miniatura, obs, status) VALUES (27, 'TEXTO-TAB', 'Título com texto - Tab Retrátil', '55a812f684fc7.png', '55a812f684fc7_mini.png', 'Deverá aparecer dois campos. Com título e texto.', NULL);


--
-- TOC entry 2069 (class 0 OID 2839925)
-- Dependencies: 1636
-- Data for Name: item_template_ferramenta; Type: TABLE DATA; Schema: custom; Owner: zioncloud3
--



--
-- TOC entry 2070 (class 0 OID 2839933)
-- Dependencies: 1638
-- Data for Name: item_template_newsletter; Type: TABLE DATA; Schema: custom; Owner: zioncloud3
--



--
-- TOC entry 2071 (class 0 OID 2839941)
-- Dependencies: 1640
-- Data for Name: template_ferramenta; Type: TABLE DATA; Schema: custom; Owner: zioncloud3
--



--
-- TOC entry 2072 (class 0 OID 2839949)
-- Dependencies: 1642
-- Data for Name: template_newsletter; Type: TABLE DATA; Schema: custom; Owner: zioncloud3
--



--
-- TOC entry 2073 (class 0 OID 2839957)
-- Dependencies: 1644
-- Data for Name: tipo_item_newsletter; Type: TABLE DATA; Schema: custom; Owner: zioncloud3
--



--
-- TOC entry 2074 (class 0 OID 2839965)
-- Dependencies: 1646
-- Data for Name: valor_item_template_newsletter; Type: TABLE DATA; Schema: custom; Owner: zioncloud3
--



SET search_path = geral, pg_catalog;

--
-- TOC entry 2057 (class 0 OID 2831079)
-- Dependencies: 1612
-- Data for Name: tb_estados; Type: TABLE DATA; Schema: geral; Owner: zioncloud3
--

INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (1, 'AC', 'Acre', 5);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (2, 'AL', 'Alagoas', 1);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (3, 'AM', 'Amazonas', 5);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (4, 'AP', 'Amapa', 5);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (5, 'BA', 'Bahia', 1);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (6, 'CE', 'Ceará', 1);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (7, 'DF', 'Distrito Federal', 2);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (8, 'ES', 'Espírito Santo', 3);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (9, 'GO', 'Goiás', 2);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (10, 'MA', 'Maranhão', 1);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (11, 'MG', 'Minas Gerais', 3);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (12, 'MS', 'Mato Grosso do Sul', 2);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (13, 'MT', 'Mato Grosso', 2);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (14, 'PA', 'Pará', 5);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (15, 'PB', 'ParaÌba', 1);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (16, 'PE', 'Pernambuco', 1);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (17, 'PI', 'Piauí', 1);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (18, 'PR', 'Paraná', 2);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (19, 'RJ', 'Rio de Janeiro', 3);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (20, 'RN', 'Rio Grande do Norte', 1);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (21, 'RO', 'Rondónia', 5);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (22, 'RR', 'Roraima', 5);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (23, 'RS', 'Rio Grande do Sul', 4);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (24, 'SC', 'Santa Catarina', 4);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (25, 'SE', 'Sergipe', 1);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (26, 'SP', 'São Paulo', 3);
INSERT INTO tb_estados (id, uf, nome, regioes_id) VALUES (27, 'TO', 'Tocantins', 5);


SET search_path = public, pg_catalog;

--
-- TOC entry 2048 (class 0 OID 2830888)
-- Dependencies: 1595
-- Data for Name: arquivo; Type: TABLE DATA; Schema: public; Owner: zioncloud3
--



--
-- TOC entry 2059 (class 0 OID 2831133)
-- Dependencies: 1617
-- Data for Name: associacao_cadastros; Type: TABLE DATA; Schema: public; Owner: zioncloud3
--



--
-- TOC entry 2049 (class 0 OID 2830901)
-- Dependencies: 1597
-- Data for Name: avaliacao_kappa; Type: TABLE DATA; Schema: public; Owner: zioncloud3
--

INSERT INTO avaliacao_kappa (id, id_registro, nome_tabela, id_componente_template, id_usuario, nota, ressalva, data, id_ticket, id_avaliacao_kappa_pai, id_avaliacao_kappa_pai_usuario, id_usuario_avaliado, tipo_avaliacao, contador, id_avaliacao_kappa_raiz) VALUES (1, 4, 'marcacao', NULL, 1, NULL, 'Vou digitar um coment&aacute;rio aqui.', '2016-04-07 19:35:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO avaliacao_kappa (id, id_registro, nome_tabela, id_componente_template, id_usuario, nota, ressalva, data, id_ticket, id_avaliacao_kappa_pai, id_avaliacao_kappa_pai_usuario, id_usuario_avaliado, tipo_avaliacao, contador, id_avaliacao_kappa_raiz) VALUES (2, 3, 'marcacao', NULL, 1, NULL, 'Mordecai esta aqui', '2016-04-07 19:41:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL);


--
-- TOC entry 2055 (class 0 OID 2831060)
-- Dependencies: 1609
-- Data for Name: cadastro_basico; Type: TABLE DATA; Schema: public; Owner: zioncloud3
--

INSERT INTO cadastro_basico (id, descricao, id_tipo_cadastro_basico, campo1, campo2, campo3, codigo) VALUES (1, 'Fogo', 2, NULL, NULL, NULL, NULL);
INSERT INTO cadastro_basico (id, descricao, id_tipo_cadastro_basico, campo1, campo2, campo3, codigo) VALUES (2, 'Água', 2, NULL, NULL, NULL, NULL);
INSERT INTO cadastro_basico (id, descricao, id_tipo_cadastro_basico, campo1, campo2, campo3, codigo) VALUES (3, 'Botucatu', 3, NULL, NULL, NULL, NULL);
INSERT INTO cadastro_basico (id, descricao, id_tipo_cadastro_basico, campo1, campo2, campo3, codigo) VALUES (4, 'Ambiente Natural', 4, NULL, NULL, NULL, '618541');


--
-- TOC entry 2061 (class 0 OID 2839602)
-- Dependencies: 1621
-- Data for Name: chat_ticket; Type: TABLE DATA; Schema: public; Owner: zioncloud3
--

INSERT INTO chat_ticket (id, data, id_ticket, ultima_interacao, status, ultima_mensagem, ultimo_lido, ids_usuarios) VALUES (1, '2016-04-11 00:09:22', 0, '2016-05-25 21:24:02', NULL, 'Mandando mensagem pelo firefox.', '2016-05-25 16:24:39.663', '1,4');


--
-- TOC entry 2062 (class 0 OID 2839615)
-- Dependencies: 1623
-- Data for Name: chat_ticket_mensagem; Type: TABLE DATA; Schema: public; Owner: zioncloud3
--

INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (1, 1, 0, 1, '2016-04-11 00:55:48', 'Nova Mensagem aqui', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (2, 1, 0, 1, '2016-04-11 00:56:52', 'Nova mensagem eu prefiro digitar aqui.', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (3, 4, 0, 1, '2016-04-11 03:15:00', 'Olá, Rafael Rend.', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (4, 4, 0, 1, '2016-04-11 03:17:33', 'Mais uma nova mensagem.', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (5, 4, 0, 1, '2016-04-11 03:59:40', 'Oi, vou ver se você vai receber esta mensagem', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (6, 4, 0, 1, '2016-04-11 04:06:17', 'Você é soviético.', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (7, 4, 0, 1, '2016-04-11 04:07:03', 'Novo Teste', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (8, 4, 0, 1, '2016-04-11 04:09:57', 'Nova mensagem', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (9, 4, 0, 1, '2016-04-11 04:16:14', 'Você é o cara.', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (10, 4, 0, 1, '2016-04-11 04:18:42', 'Por isso que eu gosto de você.', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (11, 1, 0, 1, '2016-04-11 04:19:01', 'Eu que gosto de vocÊ.', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (12, 4, 0, 1, '2016-04-11 04:19:40', '1, 1 2 , 3', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (13, 1, 0, 1, '2016-04-11 04:21:23', 'oi', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (14, 1, 0, 1, '2016-04-11 04:21:41', 'meu amigo', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (15, 4, 0, 1, '2016-04-14 04:24:47', 'Peixão, vou te mandar esta mensagem.', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (16, 1, 0, 1, '2016-04-14 05:58:33', 'Oi, Rafael', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (17, 1, 0, 1, '2016-04-14 05:58:54', 'Nova mensagem.', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (18, 1, 0, 1, '2016-04-14 06:11:12', 'Mais uma mensagem.', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (19, 1, 0, 1, '2016-04-14 06:14:09', 'Voudigitar uma novidade aqui', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (20, 1, 0, 1, '2016-04-14 06:16:52', 'Voudigitar mais uma coisa então.', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (21, 1, 0, 1, '2016-04-14 06:19:50', 'Me ajude meu brother.', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (22, 1, 0, 1, '2016-04-14 06:38:57', 'que lindo.', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (23, 1, 0, 1, '2016-04-14 06:39:18', 'cara bonito demais.', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (24, 1, 0, 1, '2016-04-14 06:41:26', 'rapaz, sou seu fã.', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (25, 4, 0, 1, '2016-04-14 06:43:41', 'obrigado meu amigo.', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (26, 4, 0, 1, '2016-04-14 06:53:59', 'Você é brother man.', 0, NULL);
INSERT INTO chat_ticket_mensagem (id, id_usuario, id_ticket, id_chat, data, mensagem, lido, data_lido) VALUES (27, 4, 0, 1, '2016-05-25 21:24:02', 'Mandando mensagem pelo firefox.', 0, NULL);


--
-- TOC entry 2063 (class 0 OID 2839632)
-- Dependencies: 1625
-- Data for Name: chat_ticket_mensagem_status; Type: TABLE DATA; Schema: public; Owner: zioncloud3
--

INSERT INTO chat_ticket_mensagem_status (id, id_mensagem, id_usuario, lido, id_chat, data_lido) VALUES (46, 23, 1, 1, 1, '2016-04-14 06:39:19');
INSERT INTO chat_ticket_mensagem_status (id, id_mensagem, id_usuario, lido, id_chat, data_lido) VALUES (45, 23, 4, 1, 1, '2016-04-14 01:38:58.613');
INSERT INTO chat_ticket_mensagem_status (id, id_mensagem, id_usuario, lido, id_chat, data_lido) VALUES (48, 24, 1, 1, 1, '2016-04-14 06:41:26');
INSERT INTO chat_ticket_mensagem_status (id, id_mensagem, id_usuario, lido, id_chat, data_lido) VALUES (47, 24, 4, 1, 1, '2016-04-14 01:43:07.578');
INSERT INTO chat_ticket_mensagem_status (id, id_mensagem, id_usuario, lido, id_chat, data_lido) VALUES (50, 25, 4, 1, 1, '2016-04-14 06:43:41');
INSERT INTO chat_ticket_mensagem_status (id, id_mensagem, id_usuario, lido, id_chat, data_lido) VALUES (49, 25, 1, 1, 1, '2016-04-14 01:43:23.364');
INSERT INTO chat_ticket_mensagem_status (id, id_mensagem, id_usuario, lido, id_chat, data_lido) VALUES (52, 26, 4, 1, 1, '2016-04-14 06:53:59');
INSERT INTO chat_ticket_mensagem_status (id, id_mensagem, id_usuario, lido, id_chat, data_lido) VALUES (51, 26, 1, 1, 1, '2016-04-14 01:53:38.856');
INSERT INTO chat_ticket_mensagem_status (id, id_mensagem, id_usuario, lido, id_chat, data_lido) VALUES (54, 27, 4, 1, 1, '2016-05-25 21:24:02');
INSERT INTO chat_ticket_mensagem_status (id, id_mensagem, id_usuario, lido, id_chat, data_lido) VALUES (53, 27, 1, 1, 1, '2016-05-25 16:24:39.679');


--
-- TOC entry 2064 (class 0 OID 2839644)
-- Dependencies: 1627
-- Data for Name: chat_ticket_participante; Type: TABLE DATA; Schema: public; Owner: zioncloud3
--

INSERT INTO chat_ticket_participante (id, id_usuario, id_ticket, id_chat, ultima_interacao, ultima_mensagem, data) VALUES (1, 4, 0, 1, '2016-05-25 21:24:02', NULL, '2016-04-11 00:09:22');
INSERT INTO chat_ticket_participante (id, id_usuario, id_ticket, id_chat, ultima_interacao, ultima_mensagem, data) VALUES (2, 1, 0, 1, '2016-05-27 15:31:15.757', NULL, '2016-04-11 00:09:22');


--
-- TOC entry 2050 (class 0 OID 2830917)
-- Dependencies: 1599
-- Data for Name: log; Type: TABLE DATA; Schema: public; Owner: zioncloud3
--



--
-- TOC entry 2058 (class 0 OID 2831103)
-- Dependencies: 1615
-- Data for Name: marcacao; Type: TABLE DATA; Schema: public; Owner: zioncloud3
--

INSERT INTO marcacao (id, tipo, titulo, texto, municipio, id_municipio, imagem, localizacao, url_livro, coordenadas, coord_x, coord_y, data_cadastro, id_usuario, usuario_cadastro, status, leaf_lat, leaf_lng, id_tipo_marcacao) VALUES (4, 'marcacao_usuario', 'Barco', NULL, 'Botucatu', 3, NULL, 'Testes', 'Testes', 'Zoom: 2, EventX: 784, EventY: 79,LAT: 709, LNG: 504, CALC_X:1008, CALC_Y: 176', 1008.00, 176.00, '2016-04-03 17:36:27', 1, 'Administrador', NULL, 1418.00, 1008.00, 2);
INSERT INTO marcacao (id, tipo, titulo, texto, municipio, id_municipio, imagem, localizacao, url_livro, coordenadas, coord_x, coord_y, data_cadastro, id_usuario, usuario_cadastro, status, leaf_lat, leaf_lng, id_tipo_marcacao) VALUES (1, 'marcacao_usuario', 'Testes', 'Testes', 'Botucatu', 3, '1_icone-otimize-o-ritmo.png', NULL, NULL, 'Zoom: 2, EventX: 585, EventY: 281,LAT: 507, LNG: 305, CALC_X:610, CALC_Y: 580', 610.00, 580.00, '2016-04-03 17:26:29', 1, 'Administrador', NULL, 1014.00, 610.00, 2);
INSERT INTO marcacao (id, tipo, titulo, texto, municipio, id_municipio, imagem, localizacao, url_livro, coordenadas, coord_x, coord_y, data_cadastro, id_usuario, usuario_cadastro, status, leaf_lat, leaf_lng, id_tipo_marcacao) VALUES (2, 'marcacao_usuario', 'Meu título vem aqui', 'Testes', 'Botucatu', 3, '2_foto_lattes.jpg', 'Testes', 'Tests', 'Zoom: 2, EventX: 820, EventY: 233,LAT: 555, LNG: 540, CALC_X:1080, CALC_Y: 484', 1080.00, 484.00, '2016-04-03 17:31:22', 1, 'Administrador', NULL, 1110.00, 1080.00, 1);
INSERT INTO marcacao (id, tipo, titulo, texto, municipio, id_municipio, imagem, localizacao, url_livro, coordenadas, coord_x, coord_y, data_cadastro, id_usuario, usuario_cadastro, status, leaf_lat, leaf_lng, id_tipo_marcacao) VALUES (3, 'marcacao_usuario', 'OI', 'Testes', 'Botucatu', 3, '3_mordecai_bitch.png', NULL, 'Tests', 'Zoom: 2, EventX: 1191, EventY: 362,LAT: 426, LNG: 911, CALC_X:1822, CALC_Y: 742', 1822.00, 742.00, '2016-04-03 17:33:56', 1, 'Administrador', NULL, 852.00, 1822.00, 2);
INSERT INTO marcacao (id, tipo, titulo, texto, municipio, id_municipio, imagem, localizacao, url_livro, coordenadas, coord_x, coord_y, data_cadastro, id_usuario, usuario_cadastro, status, leaf_lat, leaf_lng, id_tipo_marcacao) VALUES (5, 'marcacao_usuario', 'Ao lado da asa Delta', 'A asa Delta e agora vou digitar algumas coisas.', 'Botucatu', 3, '5_feijAao.jpg', 'Rua do antonio carlos, Nº 123456', NULL, 'Zoom: 2, EventX: 601, EventY: 210,LAT: 593, LNG: 823, CALC_X:1646, CALC_Y: 408', 1646.00, 408.00, '2016-04-04 01:52:16', 1, 'Administrador', NULL, 1186.00, 1646.00, 3);
INSERT INTO marcacao (id, tipo, titulo, texto, municipio, id_municipio, imagem, localizacao, url_livro, coordenadas, coord_x, coord_y, data_cadastro, id_usuario, usuario_cadastro, status, leaf_lat, leaf_lng, id_tipo_marcacao) VALUES (6, 'marcacao_usuario', 'Rafael Rend', 'Testes', 'Botucatu', 3, '6_54c00f7b8e0d4_mini.png', 'Testes', NULL, 'Zoom: 2, EventX: 682, EventY: 287,LAT: 406, LNG: 654, CALC_X:1308, CALC_Y: 782', 1308.00, 782.00, '2016-05-25 21:27:40', 1, 'Administrador', NULL, 812.00, 1308.00, 1);


--
-- TOC entry 2060 (class 0 OID 2831142)
-- Dependencies: 1619
-- Data for Name: marcacao_tipo; Type: TABLE DATA; Schema: public; Owner: zioncloud3
--

INSERT INTO marcacao_tipo (id, nome, imagem, status) VALUES (1, 'Casa', '1_blue_home.png', NULL);
INSERT INTO marcacao_tipo (id, nome, imagem, status) VALUES (2, 'Ônibus', '2_bus.png', NULL);
INSERT INTO marcacao_tipo (id, nome, imagem, status) VALUES (3, 'Natação', '3_3.png', NULL);


--
-- TOC entry 2051 (class 0 OID 2830931)
-- Dependencies: 1601
-- Data for Name: parameters; Type: TABLE DATA; Schema: public; Owner: zioncloud3
--



--
-- TOC entry 2056 (class 0 OID 2831072)
-- Dependencies: 1611
-- Data for Name: tipo_cadastro_basico; Type: TABLE DATA; Schema: public; Owner: zioncloud3
--

INSERT INTO tipo_cadastro_basico (id, descricao) VALUES (1, 'Perfil de Usuário');
INSERT INTO tipo_cadastro_basico (id, descricao) VALUES (2, 'Tipo de Marcação');
INSERT INTO tipo_cadastro_basico (id, descricao) VALUES (3, 'Município');
INSERT INTO tipo_cadastro_basico (id, descricao) VALUES (4, 'Capítulo Principal');


--
-- TOC entry 2052 (class 0 OID 2830942)
-- Dependencies: 1603
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: zioncloud3
--

INSERT INTO usuario (id, nome, sobrenome, nome_completo, data_cadastro, email, email2, imagem, identificacao_facebook, identificacao_twitter, identificacao_microsoft, identificacao_google, cpf, rg, telefone, telefone2, verificado_email, verificado_senha, codigo_verificacao, senha, endereco, id_municipio, municipio, uf, obs, metadados, perfil, auto_descricao, genero, edtr_educacao, edtr_profissao, edtr_empresa, fuso_horario, contato_seguranca, pais, data_nascimento, bairro, cep, origem_cadastro, sexo, perfil_acesso, aceitou_termo, status_aprovacao, vi_tour_protag) VALUES (4, 'Rafael Alvares Rend', NULL, 'Rafael Alvares Rend', '2016-03-07 00:00:00', 'rafaelrend@yahoo.com.br', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 'a8050a0aef6437985bd718ec07eef9', '698dc19d489c4e4db73e28a713eab07b', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'convite', NULL, 'CLI', NULL, NULL, NULL);
INSERT INTO usuario (id, nome, sobrenome, nome_completo, data_cadastro, email, email2, imagem, identificacao_facebook, identificacao_twitter, identificacao_microsoft, identificacao_google, cpf, rg, telefone, telefone2, verificado_email, verificado_senha, codigo_verificacao, senha, endereco, id_municipio, municipio, uf, obs, metadados, perfil, auto_descricao, genero, edtr_educacao, edtr_profissao, edtr_empresa, fuso_horario, contato_seguranca, pais, data_nascimento, bairro, cep, origem_cadastro, sexo, perfil_acesso, aceitou_termo, status_aprovacao, vi_tour_protag) VALUES (1, 'Administrador', NULL, 'Administrador', NULL, 'rafaelrend@gmail.com', NULL, 'arquivo:8c6b529f51.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '(71) 9877-89877', NULL, 1, NULL, NULL, '698dc19d489c4e4db73e28a713eab07b', NULL, NULL, NULL, NULL, 'Testes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1986-11-16 00:00:00', NULL, NULL, NULL, NULL, 'ADM', NULL, NULL, NULL);


--
-- TOC entry 2053 (class 0 OID 2830953)
-- Dependencies: 1605
-- Data for Name: usuario_dado; Type: TABLE DATA; Schema: public; Owner: zioncloud3
--



--
-- TOC entry 2054 (class 0 OID 2830964)
-- Dependencies: 1607
-- Data for Name: usuario_imagem; Type: TABLE DATA; Schema: public; Owner: zioncloud3
--

INSERT INTO usuario_imagem (id, imagem, tipo, id_usuario, status) VALUES (2, '0f46530e09.gif', 'arquivo', 1, 0);
INSERT INTO usuario_imagem (id, imagem, tipo, id_usuario, status) VALUES (3, '1f47a166bf.jpg', 'arquivo', 1, 0);
INSERT INTO usuario_imagem (id, imagem, tipo, id_usuario, status) VALUES (4, '0f46530e09.gif', NULL, 1, 1);
INSERT INTO usuario_imagem (id, imagem, tipo, id_usuario, status) VALUES (5, '25ac521917.jpg', 'arquivo', 1, 0);
INSERT INTO usuario_imagem (id, imagem, tipo, id_usuario, status) VALUES (6, '8c6b529f51.jpg', 'arquivo', 1, 0);


SET search_path = custom, pg_catalog;

--
-- TOC entry 2030 (class 2606 OID 2839984)
-- Dependencies: 1638 1638
-- Name: item_template_newsletter_pkey; Type: CONSTRAINT; Schema: custom; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY item_template_newsletter
    ADD CONSTRAINT item_template_newsletter_pkey PRIMARY KEY (id);


--
-- TOC entry 2019 (class 2606 OID 2839986)
-- Dependencies: 1628 1628
-- Name: pk_componente_template; Type: CONSTRAINT; Schema: custom; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY componente_template
    ADD CONSTRAINT pk_componente_template PRIMARY KEY (id);


--
-- TOC entry 2022 (class 2606 OID 2839988)
-- Dependencies: 1630 1630
-- Name: pk_componente_template_item; Type: CONSTRAINT; Schema: custom; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY componente_template_item
    ADD CONSTRAINT pk_componente_template_item PRIMARY KEY (id);


--
-- TOC entry 2024 (class 2606 OID 2839990)
-- Dependencies: 1632 1632
-- Name: pk_grupo_componente_template; Type: CONSTRAINT; Schema: custom; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY grupo_componente_template
    ADD CONSTRAINT pk_grupo_componente_template PRIMARY KEY (id);


--
-- TOC entry 2028 (class 2606 OID 2839992)
-- Dependencies: 1636 1636
-- Name: pk_itens_template_ferramenta; Type: CONSTRAINT; Schema: custom; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY item_template_ferramenta
    ADD CONSTRAINT pk_itens_template_ferramenta PRIMARY KEY (id);


--
-- TOC entry 2026 (class 2606 OID 2839994)
-- Dependencies: 1634 1634
-- Name: pk_sitem_componente; Type: CONSTRAINT; Schema: custom; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY item_componente
    ADD CONSTRAINT pk_sitem_componente PRIMARY KEY (id);


--
-- TOC entry 2034 (class 2606 OID 2839996)
-- Dependencies: 1640 1640
-- Name: template_ferramenta_pkey; Type: CONSTRAINT; Schema: custom; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY template_ferramenta
    ADD CONSTRAINT template_ferramenta_pkey PRIMARY KEY (id);


--
-- TOC entry 2036 (class 2606 OID 2839998)
-- Dependencies: 1642 1642
-- Name: template_newsletter_pkey; Type: CONSTRAINT; Schema: custom; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY template_newsletter
    ADD CONSTRAINT template_newsletter_pkey PRIMARY KEY (id);


--
-- TOC entry 2038 (class 2606 OID 2840000)
-- Dependencies: 1644 1644
-- Name: tipo_item_newsletter_pkey; Type: CONSTRAINT; Schema: custom; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY tipo_item_newsletter
    ADD CONSTRAINT tipo_item_newsletter_pkey PRIMARY KEY (id);


--
-- TOC entry 2040 (class 2606 OID 2840002)
-- Dependencies: 1646 1646
-- Name: valor_item_template_newsletter_pkey; Type: CONSTRAINT; Schema: custom; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY valor_item_template_newsletter
    ADD CONSTRAINT valor_item_template_newsletter_pkey PRIMARY KEY (id);


SET search_path = geral, pg_catalog;

--
-- TOC entry 1984 (class 2606 OID 2831086)
-- Dependencies: 1612 1612
-- Name: pk_tb_estados; Type: CONSTRAINT; Schema: geral; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY tb_estados
    ADD CONSTRAINT pk_tb_estados PRIMARY KEY (id);


SET search_path = public, pg_catalog;

--
-- TOC entry 1958 (class 2606 OID 2830896)
-- Dependencies: 1595 1595
-- Name: pk_arquivo; Type: CONSTRAINT; Schema: public; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY arquivo
    ADD CONSTRAINT pk_arquivo PRIMARY KEY (id);


--
-- TOC entry 1993 (class 2606 OID 2831138)
-- Dependencies: 1617 1617
-- Name: pk_associacao_cadastros; Type: CONSTRAINT; Schema: public; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY associacao_cadastros
    ADD CONSTRAINT pk_associacao_cadastros PRIMARY KEY (id);


--
-- TOC entry 1965 (class 2606 OID 2830909)
-- Dependencies: 1597 1597
-- Name: pk_avaliacao_kappa; Type: CONSTRAINT; Schema: public; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY avaliacao_kappa
    ADD CONSTRAINT pk_avaliacao_kappa PRIMARY KEY (id);


--
-- TOC entry 1980 (class 2606 OID 2831068)
-- Dependencies: 1609 1609
-- Name: pk_cadastro_basico; Type: CONSTRAINT; Schema: public; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY cadastro_basico
    ADD CONSTRAINT pk_cadastro_basico PRIMARY KEY (id);


--
-- TOC entry 1999 (class 2606 OID 2839610)
-- Dependencies: 1621 1621
-- Name: pk_chat_ticket; Type: CONSTRAINT; Schema: public; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY chat_ticket
    ADD CONSTRAINT pk_chat_ticket PRIMARY KEY (id);


--
-- TOC entry 2006 (class 2606 OID 2839624)
-- Dependencies: 1623 1623
-- Name: pk_chat_ticket_mensagem; Type: CONSTRAINT; Schema: public; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY chat_ticket_mensagem
    ADD CONSTRAINT pk_chat_ticket_mensagem PRIMARY KEY (id);


--
-- TOC entry 2011 (class 2606 OID 2839638)
-- Dependencies: 1625 1625
-- Name: pk_chat_ticket_mensagem_status; Type: CONSTRAINT; Schema: public; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY chat_ticket_mensagem_status
    ADD CONSTRAINT pk_chat_ticket_mensagem_status PRIMARY KEY (id);


--
-- TOC entry 2016 (class 2606 OID 2839652)
-- Dependencies: 1627 1627
-- Name: pk_chat_ticket_participante; Type: CONSTRAINT; Schema: public; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY chat_ticket_participante
    ADD CONSTRAINT pk_chat_ticket_participante PRIMARY KEY (id);


--
-- TOC entry 1969 (class 2606 OID 2830926)
-- Dependencies: 1599 1599
-- Name: pk_log; Type: CONSTRAINT; Schema: public; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY log
    ADD CONSTRAINT pk_log PRIMARY KEY (id);


--
-- TOC entry 1990 (class 2606 OID 2831111)
-- Dependencies: 1615 1615
-- Name: pk_marcacao; Type: CONSTRAINT; Schema: public; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY marcacao
    ADD CONSTRAINT pk_marcacao PRIMARY KEY (id);


--
-- TOC entry 1995 (class 2606 OID 2831150)
-- Dependencies: 1619 1619
-- Name: pk_marcacao_tipo; Type: CONSTRAINT; Schema: public; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY marcacao_tipo
    ADD CONSTRAINT pk_marcacao_tipo PRIMARY KEY (id);


--
-- TOC entry 1971 (class 2606 OID 2830939)
-- Dependencies: 1601 1601
-- Name: pk_parameters; Type: CONSTRAINT; Schema: public; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY parameters
    ADD CONSTRAINT pk_parameters PRIMARY KEY (id);


--
-- TOC entry 1982 (class 2606 OID 2831077)
-- Dependencies: 1611 1611
-- Name: pk_tipo_cadastro_basico; Type: CONSTRAINT; Schema: public; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY tipo_cadastro_basico
    ADD CONSTRAINT pk_tipo_cadastro_basico PRIMARY KEY (id);


--
-- TOC entry 1973 (class 2606 OID 2830950)
-- Dependencies: 1603 1603
-- Name: pk_usuario; Type: CONSTRAINT; Schema: public; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT pk_usuario PRIMARY KEY (id);


--
-- TOC entry 1975 (class 2606 OID 2830961)
-- Dependencies: 1605 1605
-- Name: usuario_dado_pk_usuariodado; Type: CONSTRAINT; Schema: public; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY usuario_dado
    ADD CONSTRAINT usuario_dado_pk_usuariodado PRIMARY KEY (id);


--
-- TOC entry 1977 (class 2606 OID 2830969)
-- Dependencies: 1607 1607
-- Name: usuario_imagem_pk_usuarioiterm; Type: CONSTRAINT; Schema: public; Owner: zioncloud3; Tablespace: 
--

ALTER TABLE ONLY usuario_imagem
    ADD CONSTRAINT usuario_imagem_pk_usuarioiterm PRIMARY KEY (id);


SET search_path = custom, pg_catalog;

--
-- TOC entry 2020 (class 1259 OID 2840003)
-- Dependencies: 1630
-- Name: componente_template_item_ix_id_componente_template; Type: INDEX; Schema: custom; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX componente_template_item_ix_id_componente_template ON componente_template_item USING btree (id_componente_template);


--
-- TOC entry 2017 (class 1259 OID 2840004)
-- Dependencies: 1628
-- Name: componente_template_ix_id_modulo; Type: INDEX; Schema: custom; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX componente_template_ix_id_modulo ON componente_template USING btree (id_modulo);


--
-- TOC entry 2031 (class 1259 OID 2840005)
-- Dependencies: 1640
-- Name: template_ferramenta_ix_id_ferramenta; Type: INDEX; Schema: custom; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX template_ferramenta_ix_id_ferramenta ON template_ferramenta USING btree (id_ferramenta);


--
-- TOC entry 2032 (class 1259 OID 2840006)
-- Dependencies: 1640
-- Name: template_ferramenta_ix_id_modulo; Type: INDEX; Schema: custom; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX template_ferramenta_ix_id_modulo ON template_ferramenta USING btree (id_modulo);


SET search_path = geral, pg_catalog;

--
-- TOC entry 1985 (class 1259 OID 2831087)
-- Dependencies: 1612
-- Name: tb_estados_regioes_id; Type: INDEX; Schema: geral; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX tb_estados_regioes_id ON tb_estados USING btree (regioes_id);


SET search_path = public, pg_catalog;

--
-- TOC entry 1955 (class 1259 OID 2830898)
-- Dependencies: 1595 1595
-- Name: arquivo_ix_registro; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX arquivo_ix_registro ON arquivo USING btree (id_tabela, id_registro);


--
-- TOC entry 1991 (class 1259 OID 2831139)
-- Dependencies: 1617 1617 1617
-- Name: associacao_cadastros_ix_classificacao_tabela_pai_pai; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX associacao_cadastros_ix_classificacao_tabela_pai_pai ON associacao_cadastros USING btree (classificacao, tabela_pai, id_pai);


--
-- TOC entry 1959 (class 1259 OID 2830914)
-- Dependencies: 1597
-- Name: avaliacao_kappa_ix_id_ticket; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX avaliacao_kappa_ix_id_ticket ON avaliacao_kappa USING btree (id_ticket);


--
-- TOC entry 1960 (class 1259 OID 2830912)
-- Dependencies: 1597
-- Name: avaliacao_kappa_ix_id_usuario; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX avaliacao_kappa_ix_id_usuario ON avaliacao_kappa USING btree (id_usuario);


--
-- TOC entry 1961 (class 1259 OID 2830910)
-- Dependencies: 1597 1597
-- Name: avaliacao_kappa_ix_id_usuario_ticket; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX avaliacao_kappa_ix_id_usuario_ticket ON avaliacao_kappa USING btree (id_usuario, id_ticket);


--
-- TOC entry 1962 (class 1259 OID 2830911)
-- Dependencies: 1597
-- Name: avaliacao_kappa_ix_pai; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX avaliacao_kappa_ix_pai ON avaliacao_kappa USING btree (id_avaliacao_kappa_pai);


--
-- TOC entry 1963 (class 1259 OID 2830913)
-- Dependencies: 1597 1597
-- Name: avaliacao_kappa_ix_registro; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX avaliacao_kappa_ix_registro ON avaliacao_kappa USING btree (id_registro, nome_tabela);


--
-- TOC entry 1996 (class 1259 OID 2839611)
-- Dependencies: 1621
-- Name: chat_ticket_ix_data; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX chat_ticket_ix_data ON chat_ticket USING btree (data);


--
-- TOC entry 1997 (class 1259 OID 2839612)
-- Dependencies: 1621
-- Name: chat_ticket_ix_id_ticket; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX chat_ticket_ix_id_ticket ON chat_ticket USING btree (id_ticket);


--
-- TOC entry 2000 (class 1259 OID 2839625)
-- Dependencies: 1623 1623
-- Name: chat_ticket_mensagem_ix_data; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX chat_ticket_mensagem_ix_data ON chat_ticket_mensagem USING btree (id_chat, data DESC);


--
-- TOC entry 2001 (class 1259 OID 2839626)
-- Dependencies: 1623
-- Name: chat_ticket_mensagem_ix_id_chat; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX chat_ticket_mensagem_ix_id_chat ON chat_ticket_mensagem USING btree (id_chat);


--
-- TOC entry 2002 (class 1259 OID 2839627)
-- Dependencies: 1623
-- Name: chat_ticket_mensagem_ix_id_ticket; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX chat_ticket_mensagem_ix_id_ticket ON chat_ticket_mensagem USING btree (id_ticket);


--
-- TOC entry 2003 (class 1259 OID 2839628)
-- Dependencies: 1623 1623
-- Name: chat_ticket_mensagem_ix_lido; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX chat_ticket_mensagem_ix_lido ON chat_ticket_mensagem USING btree (id_chat, lido);


--
-- TOC entry 2004 (class 1259 OID 2839629)
-- Dependencies: 1623 1623
-- Name: chat_ticket_mensagem_ix_ticket_lido; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX chat_ticket_mensagem_ix_ticket_lido ON chat_ticket_mensagem USING btree (id_ticket, lido);


--
-- TOC entry 2012 (class 1259 OID 2839658)
-- Dependencies: 1627
-- Name: chat_ticket_participante_ix_id_chat; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX chat_ticket_participante_ix_id_chat ON chat_ticket_participante USING btree (id_chat);


--
-- TOC entry 2013 (class 1259 OID 2839659)
-- Dependencies: 1627
-- Name: chat_ticket_participante_ix_id_ticket; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX chat_ticket_participante_ix_id_ticket ON chat_ticket_participante USING btree (id_ticket);


--
-- TOC entry 2014 (class 1259 OID 2839660)
-- Dependencies: 1627
-- Name: chat_ticket_participante_ix_id_usuario; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX chat_ticket_participante_ix_id_usuario ON chat_ticket_participante USING btree (id_usuario);


--
-- TOC entry 1956 (class 1259 OID 2830897)
-- Dependencies: 1595
-- Name: ix_arquivo_ticket; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX ix_arquivo_ticket ON arquivo USING btree (id_ticket);


--
-- TOC entry 2007 (class 1259 OID 2839639)
-- Dependencies: 1625 1625
-- Name: ix_chat_ticket_mensagem_status; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX ix_chat_ticket_mensagem_status ON chat_ticket_mensagem_status USING btree (id_chat, id_usuario);


--
-- TOC entry 2008 (class 1259 OID 2839640)
-- Dependencies: 1625 1625 1625
-- Name: ix_chat_ticket_mensagem_status_lido; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX ix_chat_ticket_mensagem_status_lido ON chat_ticket_mensagem_status USING btree (id_chat, id_usuario, lido);


--
-- TOC entry 2009 (class 1259 OID 2839641)
-- Dependencies: 1625
-- Name: ix_chat_ticket_mensagem_status_mensagem; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX ix_chat_ticket_mensagem_status_mensagem ON chat_ticket_mensagem_status USING btree (id_mensagem);


--
-- TOC entry 1966 (class 1259 OID 2830927)
-- Dependencies: 1599 1599
-- Name: ix_log; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX ix_log ON log USING btree (id_registro, tabela);


--
-- TOC entry 1986 (class 1259 OID 2831114)
-- Dependencies: 1615 1615
-- Name: ix_marcacao_coordenada; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX ix_marcacao_coordenada ON marcacao USING btree (coord_x, coord_y);


--
-- TOC entry 1987 (class 1259 OID 2831162)
-- Dependencies: 1615
-- Name: ix_marcacao_tipo; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX ix_marcacao_tipo ON marcacao USING btree (tipo);


--
-- TOC entry 1978 (class 1259 OID 2831069)
-- Dependencies: 1609
-- Name: ix_tipo_cadastro_basico; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX ix_tipo_cadastro_basico ON cadastro_basico USING btree (id_tipo_cadastro_basico);


--
-- TOC entry 1967 (class 1259 OID 2830928)
-- Dependencies: 1599
-- Name: log_ix_data; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX log_ix_data ON log USING btree (data);


--
-- TOC entry 1988 (class 1259 OID 2831112)
-- Dependencies: 1615
-- Name: marcacao_ix_usuario; Type: INDEX; Schema: public; Owner: zioncloud3; Tablespace: 
--

CREATE INDEX marcacao_ix_usuario ON marcacao USING btree (id_usuario);


SET search_path = custom, pg_catalog;

--
-- TOC entry 2045 (class 2606 OID 2840007)
-- Dependencies: 1636 2033 1640
-- Name: item_template_ferramenta_id_template_ferramenta_fkey; Type: FK CONSTRAINT; Schema: custom; Owner: zioncloud3
--

ALTER TABLE ONLY item_template_ferramenta
    ADD CONSTRAINT item_template_ferramenta_id_template_ferramenta_fkey FOREIGN KEY (id_template_ferramenta) REFERENCES template_ferramenta(id);


--
-- TOC entry 2046 (class 2606 OID 2840012)
-- Dependencies: 1638 1642 2035
-- Name: item_template_newsletter_id_template_newsletter_fkey; Type: FK CONSTRAINT; Schema: custom; Owner: zioncloud3
--

ALTER TABLE ONLY item_template_newsletter
    ADD CONSTRAINT item_template_newsletter_id_template_newsletter_fkey FOREIGN KEY (id_template_newsletter) REFERENCES template_newsletter(id);


--
-- TOC entry 2047 (class 2606 OID 2840017)
-- Dependencies: 1638 2037 1644
-- Name: item_template_newsletter_id_tipo_item_newsletter_fkey; Type: FK CONSTRAINT; Schema: custom; Owner: zioncloud3
--

ALTER TABLE ONLY item_template_newsletter
    ADD CONSTRAINT item_template_newsletter_id_tipo_item_newsletter_fkey FOREIGN KEY (id_tipo_item_newsletter) REFERENCES tipo_item_newsletter(id);


SET search_path = public, pg_catalog;

--
-- TOC entry 2041 (class 2606 OID 2830970)
-- Dependencies: 1972 1603 1597
-- Name: avaliacao_kappa_id_usuario_fkey; Type: FK CONSTRAINT; Schema: public; Owner: zioncloud3
--

ALTER TABLE ONLY avaliacao_kappa
    ADD CONSTRAINT avaliacao_kappa_id_usuario_fkey FOREIGN KEY (id_usuario) REFERENCES usuario(id);


--
-- TOC entry 2044 (class 2606 OID 2839653)
-- Dependencies: 1621 1998 1627
-- Name: chat_ticket_participante_fk1; Type: FK CONSTRAINT; Schema: public; Owner: zioncloud3
--

ALTER TABLE ONLY chat_ticket_participante
    ADD CONSTRAINT chat_ticket_participante_fk1 FOREIGN KEY (id_chat) REFERENCES chat_ticket(id);


--
-- TOC entry 2042 (class 2606 OID 2830975)
-- Dependencies: 1972 1603 1605
-- Name: fk_id_usuario; Type: FK CONSTRAINT; Schema: public; Owner: zioncloud3
--

ALTER TABLE ONLY usuario_dado
    ADD CONSTRAINT fk_id_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id);


--
-- TOC entry 2043 (class 2606 OID 2830980)
-- Dependencies: 1607 1603 1972
-- Name: fk_id_usuario; Type: FK CONSTRAINT; Schema: public; Owner: zioncloud3
--

ALTER TABLE ONLY usuario_imagem
    ADD CONSTRAINT fk_id_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id);


--
-- TOC entry 2078 (class 0 OID 0)
-- Dependencies: 8
-- Name: custom; Type: ACL; Schema: -; Owner: zioncloud3
--

REVOKE ALL ON SCHEMA custom FROM PUBLIC;
REVOKE ALL ON SCHEMA custom FROM zioncloud3;
GRANT ALL ON SCHEMA custom TO zioncloud3;


--
-- TOC entry 2080 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: zioncloud3
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM zioncloud3;
GRANT ALL ON SCHEMA public TO zioncloud3;
GRANT ALL ON SCHEMA public TO PUBLIC;


SET search_path = custom, pg_catalog;

--
-- TOC entry 2081 (class 0 OID 0)
-- Dependencies: 1628
-- Name: componente_template; Type: ACL; Schema: custom; Owner: zioncloud3
--

REVOKE ALL ON TABLE componente_template FROM PUBLIC;
REVOKE ALL ON TABLE componente_template FROM zioncloud3;
GRANT ALL ON TABLE componente_template TO zioncloud3;


--
-- TOC entry 2084 (class 0 OID 0)
-- Dependencies: 1630
-- Name: componente_template_item; Type: ACL; Schema: custom; Owner: zioncloud3
--

REVOKE ALL ON TABLE componente_template_item FROM PUBLIC;
REVOKE ALL ON TABLE componente_template_item FROM zioncloud3;
GRANT ALL ON TABLE componente_template_item TO zioncloud3;


--
-- TOC entry 2089 (class 0 OID 0)
-- Dependencies: 1634
-- Name: item_componente; Type: ACL; Schema: custom; Owner: zioncloud3
--

REVOKE ALL ON TABLE item_componente FROM PUBLIC;
REVOKE ALL ON TABLE item_componente FROM zioncloud3;
GRANT ALL ON TABLE item_componente TO zioncloud3;


--
-- TOC entry 2094 (class 0 OID 0)
-- Dependencies: 1638
-- Name: item_template_newsletter; Type: ACL; Schema: custom; Owner: zioncloud3
--

REVOKE ALL ON TABLE item_template_newsletter FROM PUBLIC;
REVOKE ALL ON TABLE item_template_newsletter FROM zioncloud3;
GRANT ALL ON TABLE item_template_newsletter TO zioncloud3;


--
-- TOC entry 2099 (class 0 OID 0)
-- Dependencies: 1642
-- Name: template_newsletter; Type: ACL; Schema: custom; Owner: zioncloud3
--

REVOKE ALL ON TABLE template_newsletter FROM PUBLIC;
REVOKE ALL ON TABLE template_newsletter FROM zioncloud3;
GRANT ALL ON TABLE template_newsletter TO zioncloud3;


--
-- TOC entry 2102 (class 0 OID 0)
-- Dependencies: 1644
-- Name: tipo_item_newsletter; Type: ACL; Schema: custom; Owner: zioncloud3
--

REVOKE ALL ON TABLE tipo_item_newsletter FROM PUBLIC;
REVOKE ALL ON TABLE tipo_item_newsletter FROM zioncloud3;
GRANT ALL ON TABLE tipo_item_newsletter TO zioncloud3;


SET search_path = public, pg_catalog;

--
-- TOC entry 2122 (class 0 OID 0)
-- Dependencies: 1617
-- Name: associacao_cadastros; Type: ACL; Schema: public; Owner: zioncloud3
--

REVOKE ALL ON TABLE associacao_cadastros FROM PUBLIC;
REVOKE ALL ON TABLE associacao_cadastros FROM zioncloud3;
GRANT ALL ON TABLE associacao_cadastros TO zioncloud3;


--
-- TOC entry 2129 (class 0 OID 0)
-- Dependencies: 1609
-- Name: cadastro_basico; Type: ACL; Schema: public; Owner: zioncloud3
--

REVOKE ALL ON TABLE cadastro_basico FROM PUBLIC;
REVOKE ALL ON TABLE cadastro_basico FROM zioncloud3;
GRANT ALL ON TABLE cadastro_basico TO zioncloud3;


--
-- TOC entry 2151 (class 0 OID 0)
-- Dependencies: 1619
-- Name: marcacao_tipo; Type: ACL; Schema: public; Owner: zioncloud3
--

REVOKE ALL ON TABLE marcacao_tipo FROM PUBLIC;
REVOKE ALL ON TABLE marcacao_tipo FROM zioncloud3;
GRANT ALL ON TABLE marcacao_tipo TO zioncloud3;


--
-- TOC entry 2163 (class 0 OID 0)
-- Dependencies: 1611
-- Name: tipo_cadastro_basico; Type: ACL; Schema: public; Owner: zioncloud3
--

REVOKE ALL ON TABLE tipo_cadastro_basico FROM PUBLIC;
REVOKE ALL ON TABLE tipo_cadastro_basico FROM zioncloud3;
GRANT ALL ON TABLE tipo_cadastro_basico TO zioncloud3;


-- Completed on 2016-05-30 11:50:42

--
-- PostgreSQL database dump complete
--

