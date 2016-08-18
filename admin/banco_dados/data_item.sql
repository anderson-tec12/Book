--
-- PostgreSQL database dump
--

-- Dumped from database version 8.4.22
-- Dumped by pg_dump version 9.0.3
-- Started on 2016-05-27 01:20:20

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = custom, pg_catalog;

--
-- TOC entry 2461 (class 0 OID 0)
-- Dependencies: 2024
-- Name: item_componente_id_seq; Type: SEQUENCE SET; Schema: custom; Owner: postgres
--

SELECT pg_catalog.setval('item_componente_id_seq', 27, true);


--
-- TOC entry 2458 (class 0 OID 2712036)
-- Dependencies: 2023
-- Data for Name: item_componente; Type: TABLE DATA; Schema: custom; Owner: postgres
--

INSERT INTO item_componente (id, codigo, nome, imagem, imagem_miniatura, obs, status) VALUES (3, 'VIDEO', 'Vídeo', '547634b3a0631.png', '547634b3a0631_mini.png', 'Testes', NULL);
INSERT INTO item_componente (id, codigo, nome, imagem, imagem_miniatura, obs, status) VALUES (2, 'REL', 'Relacionamento entre componentes', '547634d7d1eff.png', '547634d7d1eff_mini.png', 'Relacionamento', NULL);
INSERT INTO item_componente (id, codigo, nome, imagem, imagem_miniatura, obs, status) VALUES (24, 'IMAGEM', 'Imagem', '547635b6b814b.png', '547635b6b814b_mini.png', NULL, NULL);
INSERT INTO item_componente (id, codigo, nome, imagem, imagem_miniatura, obs, status) VALUES (23, 'INPUT-TEXT', 'Campo de entrada de texto (usuário digita)', '547635d8b63c8.png', '547635d8b63c8_mini.png', NULL, NULL);
INSERT INTO item_componente (id, codigo, nome, imagem, imagem_miniatura, obs, status) VALUES (22, 'KAPPA', 'Componente KAPPA', '5476373b3f645.png', '5476373b3f645_mini.png', NULL, NULL);
INSERT INTO item_componente (id, codigo, nome, imagem, imagem_miniatura, obs, status) VALUES (4, 'TEXTO', 'Texto (Label de Título)', '54764e5c8764a.png', '54764e5c8764a_mini.png', 'Texto de tamanho maior (Título)', NULL);
INSERT INTO item_componente (id, codigo, nome, imagem, imagem_miniatura, obs, status) VALUES (1, 'TEXTO-M', 'Texto Menor (Label de menor tamanho)', '54764fd73da5d.png', '54764fd73da5d_mini.png', 'Texto de menor tamanho', NULL);
INSERT INTO item_componente (id, codigo, nome, imagem, imagem_miniatura, obs, status) VALUES (25, 'TXT-KAPPA', 'Tópico com Kappa', '54c00f7b8e0d4.png', '54c00f7b8e0d4_mini.png', NULL, NULL);
INSERT INTO item_componente (id, codigo, nome, imagem, imagem_miniatura, obs, status) VALUES (26, 'TEXTO-P', 'Texto Parágrafo', '5591bf63a6007.png', '5591bf63a6007_mini.png', 'Texto de parágrafo.', NULL);
INSERT INTO item_componente (id, codigo, nome, imagem, imagem_miniatura, obs, status) VALUES (27, 'TEXTO-TAB', 'Título com texto - Tab Retrátil', '55a812f684fc7.png', '55a812f684fc7_mini.png', 'Deverá aparecer dois campos. Com título e texto.', NULL);


-- Completed on 2016-05-27 01:20:21

--
-- PostgreSQL database dump complete
--

