;section.bss

; nasm -f elf test.asm
; ld -m elf_i386 -s -o test test.o
; ./test

section .text
    global _start
_start:
;this is a comment
;syntax: [label] mnemonic (instruction) [operands] [comment]

   global _start     ;must be declared for linker (ld)
	
_start:	            ;tells linker entry point
    mov	    edx,len     ;message length
    mov	    ecx,msg     ;message to write
    mov	    ebx,1       ;file descriptor (stdout)
    mov	    eax,4       ;system call number (sys_write)
    int	    0x80        ;call kernel

    mov     edx,9
    mov     ecx,s2
    mov     ebx,1
    mov     eax,4
    int     0x80
        
    mov	    eax,1       ;system call number (sys_exit)
    int	    0x80        ;call kernel

section	.data
    msg db 'Write 9 stars!', 0xa  ;string to be printed
    len equ $ - msg     ;length of the string
    s2 times 9 db '*'